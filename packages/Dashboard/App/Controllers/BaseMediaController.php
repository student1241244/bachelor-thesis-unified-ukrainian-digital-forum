<?php

namespace Packages\Dashboard\App\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Packages\Dashboard\App\Models\Media;
use Storage;
use Packages\Dashboard\App\Requests\Media\RedactorJsRequest;
use Packages\Dashboard\App\Services\Media\MediaService;

class BaseMediaController extends Controller
{
    use ValidatesRequests;

    public function redactorJsUpload(RedactorJsRequest $request)
    {
        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file', []) as $k => $uploadedFile) {
                $files['file-' . $k] = MediaService::redactorJsImageUpload($uploadedFile);
            }
        }

        return $files;
    }

    /**
     * @param Media $media
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return [
            'success' => true
        ];
    }

    public function download(Media $media)
    {
        return response()->download($media->getPath(), $media->name . '.' . $media->extension);
    }
}
