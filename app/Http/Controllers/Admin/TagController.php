<?php

namespace App\Http\Controllers\Admin;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    protected $tagService;

    /**
     * TagController constructor.
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $response = $this->tagService->destroy($id);

        return $response;
    }
}
