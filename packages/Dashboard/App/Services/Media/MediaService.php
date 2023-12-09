<?php

namespace Packages\Dashboard\App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Storage;
use Packages\Dashboard\App\Models\Media;

class MediaService
{

    public static function getStorePath($alias, $size = 'original')
    {
        return $alias . '/' . $size . '/';
    }

    public static function getWebPath($alias, $size = 'original')
    {
        return Storage::url($alias . '/' . $size) . '/';
    }

    public static function redactorJsImageUpload(UploadedFile $file, $alias = 'content')
    {
        $id = $name = $file->hashName();
        $file->store(self::getStorePath('public/' . $alias));

        return [
            'url' => config('app.url') . self::getWebPath($alias) . $name,
            'id'  => $id,
        ];
    }

    /**
     * @param string $path
     * @return string|null
     */
    public static function convertImageToWebp(string $path):? string
    {
        if (!is_file($path)) {
            return null;
        }

        $mimeType = mime_content_type($path);

        if (substr_count($mimeType, 'image/')) {
            $parts = explode('.', $path);
            $ext = end($parts);
            $type = explode('/', $mimeType)[1];

            $funcNameMap = [
                'png' => 'imagecreatefrompng',
                'gif' => 'imagecreatefromgif',
                'jpg' => 'imagecreatefromjpeg',
                'jpeg' => 'imagecreatefromjpeg',
                'bmp' => 'imagecreatefrombmp',
            ];
            $func = array_get($funcNameMap, $type);

            if ($func) {
                $webpName = str_replace('.'  . $ext, '.webp', $path);

                $img = $func($path);
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                imagewebp($img, $webpName, 100);
                imagedestroy($img);

                return $webpName;
            }
        }

        return null;
    }

    /**
     * @param Media $media
     */
    public static function convertMediaToWebp(Media $media)
    {
        self::convertImageToWebp($media->getPath());
    }

    /**
     * @param UploadedFile $file
     * @return Media
     */
    public function upload(UploadedFile $file): Media
    {
        $data = [
            'uuid' => Str::uuid(),
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'file_name' => $file->hashName(),
            'disk' => 'public',
            'conversions_disk' => 'public',
            'manipulations' => [],
            'custom_properties' => [],
            'responsive_images' => [],
            'order_column' => 0,
        ];

        $media = Media::create($data);
        $file->store('public/' . $media->id);

        return $media;
    }

    /**
     * @param Media $media
     * @return array
     */
    public function formatItem(Media $media): array
    {
        return [
            'url' => $media->getUrl(),
            'hash'  => (string)$media->uuid,
            'name'  => (string)$media->file_name,
            'size'  => $this->formatSize($media->size),
        ];
    }

    public function clearTemp()
    {
        $time = date('Y-m-d H:i:s', strtotime(config('media-library.clear_temp.users', '-1 day')));

        $query = Media::query()
            ->whereNull('model_type')
            ->whereNull('model_id')
            ->whereNull('collection_name')
            ->whereNotNull('user_id')
            ->where('created_at', '<', $time);
        foreach ($query->get() as $media) {
            $media->delete();
        }

        $time = date('Y-m-d H:i:s', strtotime(config('media-library.clear_temp.guest', '-1 hour')));
        $query = Media::query()
            ->whereNull('model_type')
            ->whereNull('model_id')
            ->whereNull('collection_name')
            ->whereNull('user_id')
            ->where('created_at', '<', $time);

        foreach ($query->get() as $media) {
            $media->delete();
        }
    }

    /**
     * @param int $bytes
     * @param int $decimals
     * @return string
     */
    function formatSize(int $bytes, int $decimals = 1): string
    {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
