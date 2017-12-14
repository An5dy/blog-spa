<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FriendlyLinkService;
use App\Http\Requests\FriendlyLinkRequest;

class FriendlyLinkController extends Controller
{
    protected $friendlyLinkService;

    /**
     * FriendlyLinkController constructor.
     * @param FriendlyLinkService $friendlyLinkService
     */
    public function __construct(FriendlyLinkService $friendlyLinkService)
    {
        $this->friendlyLinkService = $friendlyLinkService;
    }

    /**
     * 友情链接
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $friendlyLinks = $this->friendlyLinkService->get();

        return view('admin.friendlyLink.index', ['friendlyLinks' => $friendlyLinks]);
    }

    /**
     * 保存链接
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.friendlyLink.add');
    }

    /**
     * 保存
     *
     * @param FriendlyLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FriendlyLinkRequest $request)
    {
        $this->friendlyLinkService->store($request);

        return redirect('/admin/friendly_links');
    }

    /**
     * 编辑页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $friendlyLink = $this->friendlyLinkService->find($id);

        return view('admin.friendlyLink.edit', ['friendlyLink' => $friendlyLink]);
    }

    /**
     * 更新
     *
     * @param FriendlyLinkRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FriendlyLinkRequest $request, $id)
    {
        $this->friendlyLinkService->update($request, $id);

        return redirect('/admin/friendly_links');
    }

    /**
     * 删除
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $response = $this->friendlyLinkService->destroy($id);

        return $response;
    }
}
