<?php

namespace Packages\Dashboard\App\Listeners;

use Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;
use Packages\Dashboard\App\Services\Media\MediaService;

class MediaLogger
{
    public function handle(MediaHasBeenAdded $event)
    {
        MediaService::convertMediaToWebp($event->media);
    }
}
