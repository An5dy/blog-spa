<?php

namespace App\Services;

use App\Exceptions\ApiErrorException;
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

    /**
     * 删除标签
     *
     * @param $id
     * @return array
     * @throws ApiErrorException
     */
    public function destroy($id)
    {
        try {
            $this->tagRepository->delete($id);

            return api_success_info('10000', '删除成功');
        } catch (\Exception $exception) {
            throw new ApiErrorException('删除失败', '20000');
        }
    }
}