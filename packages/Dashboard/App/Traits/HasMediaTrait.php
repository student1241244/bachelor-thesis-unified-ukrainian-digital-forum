<?php

namespace Packages\Dashboard\App\Traits;

use Spatie\Image\Manipulations;
use Packages\Dashboard\App\Models\Media;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\FileAdder as VendorFileAdder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile as VendorUploadedFile;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Packages\Settings\App\Models\Value;
use Packages\Settings\App\Services\SettingsService;

trait HasMediaTrait
{
    /**
     * These variables can be declared in model in order to customize media behavior:
     *
     * protected $collections = ['images'];
     * protected $conversions = ['images' => ['100x100']];
     * protected $mediaDefaults = ['images' => 'default-publication-pic'];
     */

    use InteractsWithMedia {
        InteractsWithMedia::addMedia as parentAddMedia;
        InteractsWithMedia::addMediaFromRequest as parentAddMediaFromRequest;
    }

    protected $_unsavedMedia;

    protected static function bootHasMediaTrait()
    {
        static::saved(function ($model) {
            $model->processUnsavedMedia();
        });
    }

    protected function getCollections()
    {
        return isset($this->collections)
            ? $this->collections
            : ['images'];
    }

    protected function getConversions()
    {
        return isset($this->conversions)
            ? $this->conversions
            : ['image' => ['100x100']];
    }

    protected function getMediaDefaults()
    {
        return isset($this->mediaDefaults)
            ? $this->mediaDefaults
            : ['images' => 'default-publication-pic'];
    }

    protected function processUnsavedMedia()
    {
        if (isset($this->_unsavedMedia)) {
            foreach ($this->_unsavedMedia as $collection => $files) {
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $this->addMedia($file)->toMediaCollection($collection);
                    } elseif (is_string($file)) {
                        $this->addMediaFromUrl(Media::getYouTubePreview($file, 'maxresdefault'))
                            ->usingFileName(str_random(12))
                            ->usingName(Media::getYouTubeTitle($file))
                            ->withCustomProperties(['type' => Media::TYPE_YOUTUBE, 'id' => $file])
                            ->toMediaCollection($collection);
                    }
                }
            }
        }
    }

    /**
     */
    public function setMediaAttribute($input)
    {
        foreach ($this->getCollections() as $collection) {
            $files = data_get($input, $collection);

            if ($files) {
                $this->_unsavedMedia[$collection] = array_wrap($files);
            }
        }
    }

    public function registerMediaConversions(BaseMedia $media = null): void
    {
        foreach ($this->getConversions() as $collection => $dimensions) {
            foreach ($dimensions as $dimension) {
                $size = explode('x', $dimension);

                if ($size[0] && $size[1]) {
                    $this->addMediaConversion($dimension)
                        ->fit('crop', $size[0], $size[1])
                        ->keepOriginalImageFormat()
                        ->performOnCollections($collection)
                        ->nonQueued();

                    $this->addMediaConversion($dimension)
                        ->format(Manipulations::FORMAT_WEBP)
                        ->fit('crop', $size[0], $size[1])
                        ->performOnCollections($collection)
                        ->nonQueued();
                } else {

                    $this->addMediaConversion($dimension)
                        ->fit('stretch', $size[0], $size[1])
                        ->keepOriginalImageFormat()
                        ->performOnCollections($collection)
                        ->nonQueued();

                    $this->addMediaConversion($dimension)
                        ->format(Manipulations::FORMAT_WEBP)
                        ->fit('stretch', $size[0], $size[1])
                        ->performOnCollections($collection)
                        ->nonQueued();
                }
            }
        }
    }

    protected function _getDefaultFilenameForCollection($collection): string
    {
        return $collection
            ? array_get($this->getMediaDefaults(), $collection, array_first(array_wrap($this->getMediaDefaults())))
            : array_first(array_wrap($this->getMediaDefaults()));
    }

    public function getMediaUrl($collection = '', $conversion = ''): string
    {
        $fileName = $conversion ?? $this->_getDefaultFilenameForCollection($collection);

        $placeholdersUrl = config('tpx_dashboard.placeholders-url');

        $defaultImage = $placeholdersUrl . $fileName . '.jpg';

        if (!$collection) {
            $collection = array_first($this->getCollections());
        }

        if ($collection == '_default') {
            return $defaultImage;
        }

        $image = $this->getFirstMediaUrl($collection, $conversion);

        if (!$image) {
            return $defaultImage;
        }

        $isConverted = $conversion
            ? $this->getFirstMedia($collection)->hasGeneratedConversion($conversion)
            : true;

        return $isConverted ? $image : $defaultImage;
    }

    /**
     * Add a file to the medialibrary.
     *
     * @param string|VendorUploadedFile $file
     *
     * @return VendorFileAdder
     */
    public function addMedia($file): VendorFileAdder
    {
        return $this->parentAddMedia($file)->usingFileName($file->hashName());
    }

    /**
     * Add a file to the media library that contains the given file path.
     *
     * @param string $file
     * @param string $name
     *
     * @return \Spatie\MediaLibrary\MediaCollections\FileAdder
     */
    public function addMediaFromFile(string $file, string $name): FileAdder
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'media-library');

        file_put_contents($tmpFile, file_get_contents($file));

        $file = app(FileAdderFactory::class)
            ->create($this, $tmpFile)
            ->usingFileName($name);

        return $file;
    }


    /**
     * Add a file from a request.
     *
     * @param string $key
     *
     * @return VendorFileAdder
     */
    public function addMediaFromRequest(string $key): VendorFileAdder
    {
        return $this->parentAddMediaFromRequest($key)->usingFileName(request()->file($key)->hashName());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();

        $this->addMediaCollection('preview')->singleFile();

        $this->addMediaCollection('badge')->singleFile();
    }

    /**
     * @param string $collection
     * @param string $conversion
     * @return string|null
     */
    public function getImage($collection = '', $conversion = ''):?string
    {
        return getMediaUrl($this, $collection, $conversion);
    }


    /**
     * @param string $collection
     * @param string $conversion
     * @return string|null
     */
    public function getImageOrNull($collection = '', $conversion = ''):?string
    {
        return $this->getFirstMedia($collection) ? getMediaUrl($this, $collection, $conversion) : null;
    }

    /**
     * @param $collection
     * @return string|null
     */
    public function getFileOrNull($collection):? string
    {
        $media = $this->getFirstMedia($collection);

        return $media ? $media->getUrl() : null;
    }

    /**
     * @param string $collection
     * @return array
     */
    public function getMediaValidationRules(string $collection): array
    {
        $rules = [];
        $rule_dimensions = [];
        $rule_max = null;
        $rule_mimes = null;

        $mediaRules = [];

        if (property_exists($this, 'mediaRules')) {
            $mediaRules = [];

            if (isset($this->mediaRules[$collection])) {
                $mediaRules = $this->mediaRules[$collection];
            } else if (isset($this->mediaRules['*'])) {
                $mediaRules = $this->mediaRules['*'];
            }
        } elseif (get_class($this) === Value::class) {
            $attributeConf = SettingsService::getAttributeConfig($collection);
            if (!empty($attributeConf['media_rules'])) {
                $mediaRules = $attributeConf['media_rules'];
            }
        }

        if (count($mediaRules)) {
            if (isset($mediaRules['max_size'])) {
                $maxSize = $this->getSizeInKB($mediaRules['max_size']);
            }
            $maxUploadSize = $this->getMaxUploadSizeFromIni();

            if (!isset($maxSize) || $maxSize > $maxUploadSize) {
                $maxSize = $maxUploadSize;
            }
            $rule_max = "max:{$maxSize}";

            if (isset($mediaRules['max_width'])) {
                $rule_dimensions[] = 'max_width=' . $mediaRules['max_width'];
            }
            if (isset($mediaRules['max_height'])) {
                $rule_dimensions[] = 'max_height=' . $mediaRules['max_height'];
            }
            if (isset($mediaRules['min_width'])) {
                $rule_dimensions[] = 'min_width=' . $mediaRules['min_width'];
            }
            if (isset($mediaRules['min_height'])) {
                $rule_dimensions[] = 'min_height=' . $mediaRules['min_height'];
            }
            if (isset($mediaRules['mimes'])) {
                $rule_mimes = 'mimes:' . $mediaRules['mimes'];
            }
        } else {
            $rule_max = 'max:' . $this->getMaxUploadSizeFromIni();
        }

        if ($rule_mimes) {
            $rules[] = $rule_mimes;
        }
        if ($rule_max) {
            $rules[] = $rule_max;
        }
        if (count($rule_dimensions)) {
            $rules[] = 'dimensions:' . implode(',', $rule_dimensions);
        }

        return $rules;
    }

    /**
     *
     * @param string $collection
     * @return array
     */
    public function getMediaTooltips(string $collection): array
    {
        $tooltips = [];
        $rule_dimensions = [];
        $rule_max = null;

        $mediaRules = [];

        if (property_exists($this, 'mediaRules')) {
            $mediaRules = [];

            if (isset($this->mediaRules[$collection])) {
                $mediaRules = $this->mediaRules[$collection];
            } else if (isset($this->mediaRules['*'])) {
                $mediaRules = $this->mediaRules['*'];
            }
        } elseif (get_class($this) === Value::class) {
            $attributeConf = SettingsService::getAttributeConfig($collection);
            if (!empty($attributeConf['media_rules'])) {
                $mediaRules = $attributeConf['media_rules'];
            }
        }

        if (count($mediaRules)) {
            if (isset($mediaRules['max_size'])) {
                $maxSize = $this->getSizeInKB($mediaRules['max_size']);
            }
            $maxUploadSize = $this->getMaxUploadSizeFromIni();

            if (!isset($maxSize) || $maxSize > $maxUploadSize) {
                $maxSize = $maxUploadSize;
            }
            $rule_max = $maxSize;

            if (isset($mediaRules['min_width']) && isset($mediaRules['min_height'])) {
                $tooltips[] = [
                    'label' => trans('dashboard::media.tooltips.min_width_height'),
                    'value' => "{$mediaRules['min_width']}x{$mediaRules['min_height']}px",
                ];
                unset($mediaRules['min_width']);
                unset($mediaRules['min_height']);
            }

            if (isset($mediaRules['max_width']) && isset($mediaRules['max_height'])) {
                $tooltips[] = [
                    'label' => trans('dashboard::media.tooltips.max_width_height'),
                    'value' => "{$mediaRules['max_width']}x{$mediaRules['max_height']}px",
                ];
            }

            foreach (['max_width', 'max_height', 'min_width', 'min_height'] as $attr) {
                if (isset($mediaRules[$attr])) {
                    $tooltips[] = [
                        'label' => trans('dashboard::media.tooltips.'.$attr),
                        'value' => $mediaRules[$attr] . 'px',
                    ];
                }
            }
            if (isset($mediaRules['mimes'])) {
                $tooltips[] = [
                    'label' => trans('dashboard::media.tooltips.mimes'),
                    'value' => str_replace(',', ', ', str_replace(' ', '', $mediaRules['mimes'])),
                ];
            }
        } else {
            $rule_max = $this->getMaxUploadSizeFromIni();
        }

        if ($rule_max) {
            $tooltips[] = [
                'label' => trans('dashboard::media.tooltips.max_size'),
                'value' =>  round($rule_max/1024, 1) . ' MB.',
            ];
        }

        return $tooltips;
    }

    /**
     * @return int
     */
    public function getMaxUploadSizeFromIni(): int
    {
        return min(
            $this->getSizeInKB(ini_get('upload_max_filesize')),
            $this->getSizeInKB(ini_get('post_max_size'))
        );
    }

    /**
     * @param string $value
     * @return int
     */
    public function getSizeInKB(string $value): int
    {
        $value = strtolower($value);
        $mapUnit = [
            'b' => 0,
            'k' => 1,
            'm' => 1024,
            'g' => 1024 * 1024,
        ];

        $unitName = substr($value, -1);
        if (!isset($mapUnit[$unitName])) {
            $unitName = 'm';
        }

        $value = (int)$value;
        $perByte = array_get($mapUnit, $unitName, 1);

        $value = $value * $perByte;

        return  max(1, $value);
    }
}
