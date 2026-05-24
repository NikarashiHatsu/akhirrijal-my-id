<?php

namespace App\Services;

use App\Models\Photo;
use GdImage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PhotoImageProcessor
{
    /**
     * @param  array<int, int>  $variantWidths
     */
    public function __construct(
        private array $variantWidths = [],
        private int $webpQuality = 82,
        private string $originalDirectory = 'uploaded/original',
        private string $compressedDirectory = 'uploaded/compressed',
    ) {
        $this->variantWidths = $variantWidths ?: config('photos.variant_widths', [480, 900, 1600, 2400]);
        $this->webpQuality = $webpQuality ?: (int) config('photos.webp_quality', 82);
        $this->originalDirectory = $originalDirectory ?: (string) config('photos.original_directory', 'uploaded/original');
        $this->compressedDirectory = $compressedDirectory ?: (string) config('photos.compressed_directory', 'uploaded/compressed');
    }

    public function process(Photo $photo, string $stagingPath, string $stagingDisk = 'public'): void
    {
        $staging = Storage::disk($stagingDisk);

        if (! $staging->exists($stagingPath)) {
            throw new RuntimeException("Staging file not found: {$stagingPath}");
        }

        $source = $this->createImageResource($staging->path($stagingPath));

        if (! $source instanceof GdImage) {
            throw new RuntimeException('Unable to read uploaded image.');
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);

        $extension = strtolower(pathinfo($stagingPath, PATHINFO_EXTENSION) ?: 'jpg');

        $this->deleteExistingAssets($photo);

        $originalPath = $this->storeOriginal($photo, $staging, $stagingPath, $extension);

        $variants = $this->generateVariants($photo, $source, $sourceWidth, $sourceHeight);

        imagedestroy($source);

        if ($variants === []) {
            throw new RuntimeException('Unable to generate compressed variants.');
        }

        $largestVariant = $this->largestVariant($variants);

        $photo->update([
            'original_path' => $originalPath,
            'original_disk' => 'local',
            'variants' => $variants,
            'image_path' => $largestVariant['path'],
            'disk' => 'public',
            'width' => $sourceWidth,
            'height' => $largestVariant['height'],
        ]);

        $staging->delete($stagingPath);
    }

    public function deleteAssets(Photo $photo): void
    {
        if ($photo->original_path) {
            Storage::disk($photo->original_disk ?? 'local')->delete($photo->original_path);
        }

        if (is_array($photo->variants) && $photo->variants !== []) {
            foreach ($photo->variants as $variant) {
                if (! empty($variant['path'])) {
                    Storage::disk('public')->delete($variant['path']);
                }
            }

            return;
        }

        if ($photo->image_path) {
            Storage::disk($photo->disk ?? 'public')->delete($photo->image_path);
        }
    }

    private function deleteExistingAssets(Photo $photo): void
    {
        if (! $photo->original_path && ! $photo->variants && ! $photo->image_path) {
            return;
        }

        $this->deleteAssets($photo);
    }

    private function storeOriginal(Photo $photo, Filesystem $staging, string $stagingPath, string $extension): string
    {
        $originalPath = "{$this->originalDirectory}/{$photo->id}/original.{$extension}";

        Storage::disk('local')->put(
            $originalPath,
            $staging->get($stagingPath),
        );

        return $originalPath;
    }

    /**
     * @return list<array{width: int, height: int, path: string}>
     */
    private function generateVariants(Photo $photo, GdImage $source, int $sourceWidth, int $sourceHeight): array
    {
        $widths = collect($this->variantWidths)
            ->filter(fn (int $width): bool => $width <= $sourceWidth)
            ->values();

        if ($widths->isEmpty()) {
            $widths = collect([$sourceWidth]);
        }

        $variants = [];

        foreach ($widths as $targetWidth) {
            $targetHeight = (int) round($sourceHeight * ($targetWidth / $sourceWidth));
            $variantPath = "{$this->compressedDirectory}/{$photo->id}/{$targetWidth}w.webp";

            if ($targetWidth === $sourceWidth) {
                $canvas = $source;
                $shouldDestroy = false;
            } else {
                $canvas = $this->resizeToWidth($source, $sourceWidth, $sourceHeight, $targetWidth);
                $shouldDestroy = true;
            }

            $this->writeWebp($canvas, $variantPath);

            if ($shouldDestroy) {
                imagedestroy($canvas);
            }

            $variants[] = [
                'width' => $targetWidth,
                'height' => $targetHeight,
                'path' => $variantPath,
            ];
        }

        return $variants;
    }

    private function resizeToWidth(GdImage $source, int $sourceWidth, int $sourceHeight, int $targetWidth): GdImage
    {
        $targetHeight = (int) round($sourceHeight * ($targetWidth / $sourceWidth));
        $resized = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresampled(
            $resized,
            $source,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight,
        );

        return $resized;
    }

    private function writeWebp(GdImage $image, string $publicPath): void
    {
        if (! function_exists('imagewebp')) {
            throw new RuntimeException('WebP encoding is not available in this PHP build.');
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'photo-webp-');

        if ($tempPath === false) {
            throw new RuntimeException('Unable to create temporary file for WebP encoding.');
        }

        try {
            if (! imagewebp($image, $tempPath, $this->webpQuality)) {
                throw new RuntimeException('WebP encoding failed.');
            }

            Storage::disk('public')->put($publicPath, (string) file_get_contents($tempPath));
        } finally {
            if (is_file($tempPath)) {
                unlink($tempPath);
            }
        }
    }

    private function createImageResource(string $path): GdImage|false
    {
        $mime = mime_content_type($path) ?: '';

        return match (true) {
            str_contains($mime, 'jpeg'), str_contains($mime, 'jpg') => imagecreatefromjpeg($path),
            str_contains($mime, 'png') => imagecreatefrompng($path),
            str_contains($mime, 'webp') => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : false,
            str_contains($mime, 'gif') => imagecreatefromgif($path),
            default => @imagecreatefromstring((string) file_get_contents($path)),
        };
    }

    /**
     * @param  list<array{width: int, height: int, path: string}>  $variants
     * @return array{width: int, height: int, path: string}
     */
    private function largestVariant(array $variants): array
    {
        return collect($variants)->sortByDesc('width')->first();
    }
}
