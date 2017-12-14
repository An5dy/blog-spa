<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryService->getList();

        return view('admin.category.index', ['categories' => $categories]);
    }

    /**
     * 标签创建页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * 保存分类
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->store($request);

        return redirect('/admin/categories');
    }

    /**
     * 修改页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryService->find($id);

        return view('admin.category.edit', ['category' => $category]);
    }

    /**
     * 修改
     *
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($request, $id);

        return redirect('/admin/categories');
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $response = $this->categoryService->destroy($id);

        return $response;
    }
}
