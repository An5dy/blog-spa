<?php

namespace App\Http\Controllers\Api;

use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginService;

    /**
     * 注入LoginService
     *
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * 用户登录
     *
     * @param LoginRequest $request
     * @return $this
     */
    public function login(LoginRequest $request)
    {
        $response = $this->loginService->login($request);

        return $response;
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $response = $this->loginService->logout($request);

        return $response;
    }

    /**
     * 刷新token
     *
     * @return $this
     */
    public function refresh()
    {
        $response = $this->loginService->refresh();

        return $response;
    }
}
