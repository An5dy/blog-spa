<?php

namespace App\Services;

use App\Libs\GeeTestCaptcha\GeeCaptcha;

class GeeTestCaptchaService
{
    protected $geeCaptcha;

    /**
     * 注入GeeCaptcha
     *
     * GeeTestCaptchaService constructor.
     * @param GeeCaptcha $geeCaptcha
     */
    public function __construct(GeeCaptcha $geeCaptcha)
    {
        $this->geeCaptcha = $geeCaptcha;
    }

    /**
     * 获取验证码
     *
     * @return mixed
     */
    public function get()
    {
        return \GuzzleHttp\json_decode($this->geeCaptcha->getCaptcha());
    }
}