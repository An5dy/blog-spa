<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $categoryService;

    /**
     * 注入CategoryService
     *
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 列表
     *
     * @return \App\Http\Resources\CategoryCollection
     */
    public function index()
    {
        $categories = $this->categoryService->list();

        return $categories;
    }
}
