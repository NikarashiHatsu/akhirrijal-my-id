<?php

namespace App\Models;

use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    /** @use HasFactory<PhotoFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'series_id' => 'integer',
            'sort_order' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'taken_at' => 'date',
            'variants' => 'array',
        ];
    }

    /** @return BelongsTo<Series, $this> */
    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function url(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk($this->disk ?? 'public')->url($this->image_path);
    }

    public function displayUrl(?int $width = null): ?string
    {
        if ($width === null) {
            return $this->url();
        }

        $variant = $this->variantCollection()->firstWhere('width', $width)
            ?? $this->variantCollection()->sortBy(fn (array $item): int => abs($item['width'] - $width))->first();

        if ($variant !== null) {
            return Storage::disk('public')->url($variant['path']);
        }

        return $this->url();
    }

    public function srcset(): string
    {
        return $this->variantCollection()
            ->map(fn (array $variant): string => Storage::disk('public')->url($variant['path']).' '.$variant['width'].'w')
            ->implode(', ');
    }

    public function lightboxUrl(): ?string
    {
        $largest = $this->largestVariant();

        if ($largest !== null) {
            return Storage::disk('public')->url($largest['path']);
        }

        return $this->url();
    }

    /**
     * @return array{width: int, height: int}
     */
    public function lightboxDimensions(): array
    {
        $largest = $this->largestVariant();

        if ($largest !== null) {
            return [
                'width' => $largest['width'],
                'height' => $largest['height'],
            ];
        }

        return [
            'width' => $this->width ?? 1600,
            'height' => $this->height ?? 1067,
        ];
    }

    /**
     * @return Collection<int, array{width: int, height: int, path: string}>
     */
    private function variantCollection(): Collection
    {
        return collect($this->variants ?? []);
    }

    /**
     * @return array{width: int, height: int, path: string}|null
     */
    private function largestVariant(): ?array
    {
        return $this->variantCollection()->sortByDesc('width')->first();
    }
}
