<?php

namespace App\Services;


use App\Exceptions\ApiErrorException;
use App\Http\Resources\CategoryCollection;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    protected $categoryRepository;

    /**
     * 注入CategoryRepository
     *
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * 返回列表
     *
     * @return CategoryCollection
     */
    public function list()
    {
        $categories = $this->categoryRepository->get(['id', 'title']);

        return new CategoryCollection($categories);
    }

    /**
     * 获取分类列表
     *
     * @return mixed
     */
    public function getList()
    {
        $categories = $this->categoryRepository->paginate(null, ['id', 'title', 'created_at']);

        return $categories;
    }

    /**
     * 保存分类
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $attributes = ['title' => $request->title];
        $category = $this->categoryRepository->firstOrCreate($attributes);

        return $category;
    }

    /**
     * 分类详情
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $category = $this->categoryRepository->find($id, ['id', 'title']);

        return $category;
    }

    /**
     * 编辑
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return $this->categoryRepository
                    ->update(['title' => $request->title],$id);
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);

            return api_success_info('10000', '删除成功');
        } catch (\Exception $exception) {
            throw new ApiErrorException('删除失败', '20000');
        }
    }
}