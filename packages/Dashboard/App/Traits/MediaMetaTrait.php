<?php


namespace App\Traits;

use App\Services\MediaService;
use Illuminate\Support\Facades\Artisan;
use Packages\Dashboard\App\Models\Media;

trait MediaMetaTrait
{
    /**
     * @param string $collection
     * @param array $meta
     * @param bool $deleteOld
     */
    public function addMediaFromMeta(string $collection, array $meta, bool $deleteOld = true)
    {
        $oldMedia = null;
        if ($deleteOld) {
            $oldMedia = Media::query()
                ->where('collection_name', $collection)
                ->where('model_type', get_class($this))
                ->where('model_id', $this->id)
                ->first();
        }

        $media = Media::where('uuid', array_get($meta, 'hash'))->first();
        if ($media) {
            $media->update([
                'collection_name' => $collection,
                'model_type' => get_class($this),
                'model_id' => $this->id,
            ]);
            Artisan::call('media-library:regenerate --ids=' . $media->id);
        }

        if ($oldMedia && $media && $oldMedia->id !== $media->id) {
            $oldMedia->delete();
        }
    }

    /**
     * @param string $collection
     * @return array|null
     */
    public function getMediaMeta(string $collection):? array
    {
        $media = $this->getFirstMedia($collection);

        if ($media) {
            return (new MediaService)->formatItem($media);
        }

        return null;
    }
}
