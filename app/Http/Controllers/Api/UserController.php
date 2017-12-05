<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserInfoUpdateRequest;

class UserController extends Controller
{
    protected $userService;

    /**
     * 注入UserService
     *
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 获取用户信息
     *
     * @param Request $request
     * @return \App\Http\Resources\UserResource
     */
    public function getUserInfo(Request $request)
    {
        $userInfo = $this->userService->getUserInfo($request);

        return $userInfo;
    }

    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return Request
     */
    public function update(UserInfoUpdateRequest $request)
    {
        $response = $this->userService->update($request);

        return $response;
    }

    /**
     * 修改密码
     *
     * @param PasswordUpdateRequest $request
     * @return array
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $response = $this->userService->updatePassword($request);

        return $response;
    }
}
