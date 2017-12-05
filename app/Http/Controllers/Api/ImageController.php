<?php

namespace App\Http\Controllers\Api;

use App\Services\ImageService;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    protected $imageService;

    /**
     * 注入ImageService
     *
     * ImageController constructor.
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * 上传图片并返回信息
     *
     * @param ImageRequest $request
     * @return array
     */
    public function upload(ImageRequest $request)
    {
        $response = $this->imageService->upload();

        return $response;
    }
}
