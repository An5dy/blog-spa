<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeeTestCaptchaService;

class CaptchaController extends Controller
{
    protected $geeTestCaptchaService;

    /**
     * 注入GeeTestCaptchaService
     *
     * CaptchaController constructor.
     * @param GeeTestCaptchaService $geeTestCaptchaService
     */
    public function __construct(GeeTestCaptchaService $geeTestCaptchaService)
    {
        $this->geeTestCaptchaService = $geeTestCaptchaService;
    }

    /**
     * 获取验证码
     *
     * @return array
     */
    public function getCaptcha()
    {
        $captcha = $this->geeTestCaptchaService->get();

        return api_success_info('10000', '获取成功', ['captcha' => $captcha]);
    }

    public function verifyCaptcha()
    {

    }
}
