<?php

namespace App\Filament\Resources\Photos\Pages;

use App\Filament\Resources\Photos\PhotoResource;
use App\Services\PhotoImageProcessor;
use Filament\Resources\Pages\CreateRecord;

class CreatePhoto extends CreateRecord
{
    protected static string $resource = PhotoResource::class;

    protected ?string $pendingUploadPath = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->pendingUploadPath = $data['image_path'] ?? null;
        $data['image_path'] = '';

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->pendingUploadPath) {
            app(PhotoImageProcessor::class)->process($this->record, $this->pendingUploadPath);
        }
    }
}
