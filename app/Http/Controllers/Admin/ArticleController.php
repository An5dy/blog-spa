<?php

namespace App\Http\Controllers\Admin;

use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $articleService;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * 获取文章列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->list($request);

        return view('admin.article.index', ['articles' => $articles]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $response = $this->articleService->destroy($id);

        return $response;
    }
}
