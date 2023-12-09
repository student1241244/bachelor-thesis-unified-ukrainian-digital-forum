<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Image;

class Media extends BaseMedia
{
    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return (new Image())->canHandleMime($this->mime_type);
    }

    /**
     * @return bool
     */
    public function isSvg():bool
    {
        return in_array($this->mime_type, ['image/svg+xml']);
    }


    /**
     * @return string
     */
    public function getExtensionAttribute(): string
    {
        return Str::afterLast($this->file_name, '.');
    }

    /**
     * @return string
     */
    public function getFontAwesomeClass(): string
    {
        if ($this->isImage()) {
            return 'file-image-o';
        }

        switch ($this->getExtensionAttribute()) {
            case 'zip':
            case 'rar':
                $faClass = 'file-zip-o';
                break;
            case 'ppt':
            case 'pptx':
                $faClass = 'file-powerpoint-o';
                break;
            case 'xls':
            case 'xlsx':
                $faClass = 'file-excel-o';
                break;
            case 'doc':
            case 'docx':
                $faClass = 'file-word-o';
                break;
            case 'mp3':
                $faClass = 'file-audio-o';
                break;
            case 'wmv':
            case 'mp4':
                $faClass = 'file-video-o';
                break;
            case 'pdf':
                $faClass = 'file-pdf-o';
                break;
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'webp':
                $faClass = 'file-image-o';
                break;
            default:
                $faClass = 'file-o';
        }

        return $faClass;
    }


    public function getFullName()
    {
        return $this->name . '.' . $this->getExtensionAttribute();
    }

    public function getFullNameAttribute()
    {
        return $this->getFullName();
    }
}
