<?php

namespace App\Services;

use DB;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Exceptions\ApiErrorException;

class RegisterService
{
    protected $userRepository;

    /**
     * 注入UserRepository
     *
     * RegisterService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 保存用户
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // 使用验证码
            $request->verificationCode->update(['status' => 1]);
            // 保存数据
            $data = [
                'name' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ];
            $user = $this->userRepository->create($data);
            DB::commit();

            return new UserResource($user);
        } catch (\Exception $exception) {
            DB::rollback();
            if ($exception instanceof ApiErrorException) {
                throw new ApiErrorException($exception->getMessage(), $exception->getCode());
            }
            throw new ApiErrorException('系统错误', '20000');
        }
    }
}