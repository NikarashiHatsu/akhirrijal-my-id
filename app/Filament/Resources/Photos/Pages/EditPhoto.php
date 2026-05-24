<?php

namespace App\Filament\Resources\Photos\Pages;

use App\Filament\Resources\Photos\PhotoResource;
use App\Services\PhotoImageProcessor;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPhoto extends EditRecord
{
    protected static string $resource = PhotoResource::class;

    protected ?string $pendingUploadPath = null;

    protected bool $shouldReprocess = false;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $incomingPath = $data['image_path'] ?? null;
        $existingPath = $this->record->image_path;

        if (filled($incomingPath) && $incomingPath !== $existingPath) {
            $this->pendingUploadPath = $incomingPath;
            $this->shouldReprocess = true;
            unset($data['image_path']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->shouldReprocess && $this->pendingUploadPath) {
            app(PhotoImageProcessor::class)->process($this->record, $this->pendingUploadPath);

            $this->pendingUploadPath = null;
            $this->shouldReprocess = false;
        }
    }
}
