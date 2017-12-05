<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $articleService;

    /**
     * 注入ArticleService
     *
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * 列表
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->getList($request);

        return $articles;
    }

    /**
     * 获取列表
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $articles = $this->articleService->getList($request);

        return $articles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $response = $this->articleService->store($request);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->articleService->show($id);

        return $response;
    }

    /**
     * 侧边栏
     *
     * @return array
     */
    public function getSidebar()
    {
        $response = $this->articleService->getSidebarData();

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = $this->articleService->edit($id);

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = $this->articleService->store($request, $id);

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->articleService->delete($id);

        return $response;
    }
}
