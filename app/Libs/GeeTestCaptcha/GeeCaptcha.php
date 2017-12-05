<?php

namespace App\Libs\GeeTestCaptcha;

use App\Exceptions\ApiErrorException;

class GeeCaptcha extends GeeTestLib
{
    /**
     * 重写构造函数
     *
     * GeeCaptcha constructor.
     */
    public function __construct()
    {
        $this->captcha_id = config('global.geetest.captcha_id');
        $this->private_key = config('global.geetest.private_key');
    }

    /**
     * 获取验证码
     *
     * @return mixed
     */
    public function getCaptcha()
    {
        $data = $this->setData();
        $status = $this->pre_process($data, 1);
        cache()->put('gtserver', $status, 15);

        return $this->get_response_str();
    }

    /**
     * 验证验证码
     *
     * @param $challenge
     * @param $validate
     * @param $seccode
     * @throws ApiErrorException
     */
    public function verifyCaptcha($challenge, $validate, $seccode)
    {
        $data = $this->setData();
        if ($this->isServiceOk()) {
            $result = $this->success_validate($challenge, $validate, $seccode, $data);
        } else {
            $result = $this->fail_validate($challenge, $validate, $seccode);
        }
        if (! $result) { throw new ApiErrorException('验证码错误', '20000'); }
    }

    /**
     * 验证geetest服务器是否正常
     *
     * @return bool
     */
    protected function isServiceOk()
    {
        return cache()->get('gtserver') == 1;
    }


    /**
     * 设置data
     *
     * @return array
     */
    protected function setData()
    {
        return [
            'client_type' => 'web',
            'ip_address' => request()->getClientIp()
        ];
    }
}