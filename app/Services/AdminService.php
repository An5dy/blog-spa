<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminService
{
    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $user = user('admin');
        $boolean = Hash::check($request->oldPassword, $user->getAuthPassword());
        if ($boolean) {
            if ($request->name != $user->name) {
                $user->name = $request->name;
            }
            if (! empty($request->newPassword)) {
                $user->password = bcrypt($request->newPassword);
            }
            $user->save();
            // 退出登录
            Auth::logout();
        } else {
            throw ValidationException::withMessages(['olPassword' => ['原密码错误']]);
        }
    }
}