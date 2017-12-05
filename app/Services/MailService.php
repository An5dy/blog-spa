<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Criteria\EmailCriteria;
use App\Criteria\TimeLimitCriteria;
use App\Mail\UserVerificationEmail;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\ApiErrorException;
use App\Criteria\VerifyEmailCodeCriteria;
use App\Repositories\VerificationCodeRepository;

class MailService
{
    protected $verificationCodeRepository;

    /**
     * 注入VerificationCodeRepository
     *
     * MailService constructor.
     * @param VerificationCodeRepository $verificationCodeRepository
     */
    public function __construct(VerificationCodeRepository $verificationCodeRepository)
    {
        $this->verificationCodeRepository = $verificationCodeRepository;
    }

    /**
     * 发送验证码
     *
     * @param Request $request
     * @throws ApiErrorException
     */
    public function send(Request $request)
    {
        DB::beginTransaction();
//        try {
            $data = [
                'email' => $request->email,
                'code' => random_int(1000, 9999),
            ];
            // 保存验证码
            $verificationCode = $this->verificationCodeRepository->create($data);
            // 发送邮件
            Mail::to($verificationCode->email)
                ->send(new UserVerificationEmail($verificationCode));
//            DB::commit();
//        } catch (\Exception $exception) {
//            DB::rollback();
//            throw new ApiErrorException('邮件发送失败', '30000');
//        }
    }

    /**
     * 判断验证码是否正确
     *
     * @param Request $request
     * @throws ApiErrorException
     */
    public function verify(Request $request)
    {
        // 设置查询条件
        $this->verificationCodeRepository->pushCriteria(new VerifyEmailCodeCriteria());
        // 查询
        $verificationCode = $this->verificationCodeRepository
                                 ->orderBy('id', 'desc')
                                 ->first();
        if (empty($verificationCode)) {
            throw new ApiErrorException('验证码错误', '30000');
        } else {
            if ($verificationCode->created_at < Carbon::now()->subMinute(15)) {
                throw new ApiErrorException('当前验证码已过期', '30000');
            } else if ($verificationCode->status == 1) {
                throw new ApiErrorException('验证码已使用', '30000');
            } else {
                return $verificationCode;
            }
        }
    }

    /**
     * 检查邮件
     *
     * @throws ApiErrorException
     */
    public function checkEmail()
    {
        // 设置查询条件
        $this->verificationCodeRepository->pushCriteria(new EmailCriteria());
        $this->verificationCodeRepository->pushCriteria(new TimeLimitCriteria());
        // 总条数
        $count = $this->verificationCodeRepository->count();

        $limit = config('global.email.limit');
        if ($count < $limit) {
            $verificationCode = $this->verificationCodeRepository
                ->orderBy('id', 'desc')
                ->first();
            $timeout = config('global.email.timeout');
            if (! empty($verificationCode) &&
                $verificationCode->created_at > Carbon::now()->subMinute($timeout)) {
                throw new ApiErrorException(config('global.email.error.timeout')($timeout), '30000');
            }
        } else {
            throw new ApiErrorException(config('global.email.error.limit')($limit), '30000');
        }
    }
}