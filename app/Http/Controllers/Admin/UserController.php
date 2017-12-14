<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 用户列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = $this->userService->list($request);

        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * 禁止用户登录
     *
     * @param $id
     * @return mixed
     */
    public function toggleBan($id)
    {
        $response = $this->userService->toggleBan($id);

        return $response;
    }
}
