<?php

namespace App\Observers;

use App\Models\Photo;
use App\Services\PhotoImageProcessor;

class PhotoObserver
{
    public function __construct(private PhotoImageProcessor $processor) {}

    public function deleted(Photo $photo): void
    {
        $this->processor->deleteAssets($photo);
    }
}
