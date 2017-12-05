<?php

namespace App\Http\Controllers\Api;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    protected $tagService;

    /**
     * 注入TagService
     *
     * TagController constructor.
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * 返回列表
     *
     * @param Request $request
     * @return \App\Http\Resources\TagCollection
     */
    public function list(Request $request)
    {
        $response = $this->tagService->list($request);

        return $response;
    }
}
