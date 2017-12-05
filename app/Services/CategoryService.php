<?php

namespace App\Services;


use App\Http\Resources\CategoryCollection;
use App\Repositories\CategoryRepository;

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
}