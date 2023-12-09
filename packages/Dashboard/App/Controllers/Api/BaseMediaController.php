<?php

namespace Packages\Dashboard\App\Controllers\Api;

use Packages\Dashboard\App\Requests\Api\Media\UploadRequest;
use App\Http\Controllers\Controller;
use Packages\Dashboard\App\Services\Media\MediaService;

/**
 * @group  Media
 */
class BaseMediaController extends Controller
{
    /**
     * BaseMediaController constructor.
     * @param MediaService $mediaService
     */
    public function __construct(private MediaService $mediaService)
    {
    }

    /**
     * Upload
     *
     * @responseFile  200 responses/media/upload/200.json
     * @responseFile  422 responses/media/upload/422.json
     *
     * @param UploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(UploadRequest $request)
    {
        $file = $this->mediaService->upload($request->file('file'));

        return response()->json($this->mediaService->formatItem($file));
    }

}
