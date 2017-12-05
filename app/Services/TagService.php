<?php

namespace App\Services;

use App\Http\Resources\TagCollection;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagService
{
    protected $tagRepository;

    /**
     * 注入TagRepository
     *
     * TagService constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * 返回列表数据
     *
     * @param Request $request
     * @return TagCollection
     */
    public function list(Request $request)
    {
        $tags = $this->tagRepository
                     ->scopeQuery(function ($query) use ($request){
                        return $query->title($request->title);
                     })
                     ->get(['id', 'title']);


        return new TagCollection($tags);
    }
}