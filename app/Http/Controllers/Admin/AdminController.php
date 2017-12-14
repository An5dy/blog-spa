<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $adminService;

    /**
     * AdminController constructor.
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * 后台用户详情
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = user('admin');

        return view('admin.index', ['user' => $user]);
    }

    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AdminRequest $request)
    {
        $this->adminService->update($request);

        return redirect('/admin');
    }
}
