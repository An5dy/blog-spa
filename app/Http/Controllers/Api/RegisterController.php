<?php

namespace App\Http\Controllers\Api;

use App\Services\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    protected $registerService;

    /**
     * 注入RegisterService
     *
     * RegisterController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * 注册用户
     *
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        // 保存注册用户
        $data = $this->registerService->create($request);

        return $data;
    }
}
