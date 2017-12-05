<?php

namespace App\Services;

use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * 返回user信息
     *
     * @param Request $request
     * @return UserResource
     */
    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return UserResource
     */
    public function update(Request $request)
    {
        $data = collect([
            'name' => $request->name,
            'avatar' => $request->avatar,
            'avatar_thumb' => $request->avatar_thumb
        ])->reject(function ($param) {
            return empty($param);
        })->toArray();
        if (empty($data)) { throw new ApiErrorException('修改的内容不能为空', '20000'); }
        $user = $request->user();
        $user->update($data);

        return new UserResource($user);
    }

    /**
     * 修改密码
     *
     * @param Request $request
     * @return array
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return api_success_info('10000', '修改成功');
    }
}