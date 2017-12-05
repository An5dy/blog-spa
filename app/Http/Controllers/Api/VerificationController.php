<?php

namespace App\Http\Controllers\Api;

use App\Services\MailService;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationRequest;

class VerificationController extends Controller
{
    protected $mailService;

    /**
     * 注入MailService
     *
     * VerificationController constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * 发送邮件
     *
     * @param VerificationRequest $request
     * @return array
     */
    public function send(VerificationRequest $request)
    {
        $this->mailService->send($request);

        return api_success_info('10000', '邮件发送成功');
    }
}
