<?php

namespace App\Services;

use DB;
use Illuminate\Http\Request;
use App\Http\Proxy\TokenProxy;
use App\Exceptions\ApiErrorException;

class LoginService
{
    protected $grandType = 'password';

    protected $scope = '';

    protected $tokenProxy;

    /**
     * 注入TokenProxy
     *
     * LoginService constructor.
     * @param TokenProxy $tokenProxy
     */
    public function __construct(TokenProxy $tokenProxy)
    {
        $this->tokenProxy = $tokenProxy;
    }

    /**
     * 用户登录
     *
     * @param Request $request
     * @return $this
     * @throws ApiErrorException
     */
    public function login(Request $request)
    {
        if (auth()->once($this->credentials($request))) {
            if (auth()->user()->status == 1) {
                return api_error_info('20000', '用户禁止登录');
            }
            // 获取token值
            $token = $this->tokenProxy->getToken($this->grandType, [
                'username' => $request->email,
                'password' => $request->password,
                'scope' => $this->scope,
            ]);

            return $this->response($token);
        } else {
            throw new ApiErrorException('用户不存在或密码错误', '20000');
        }
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = auth()->guard('api')->user();

        $accessToken = $user->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)
                                         ->update(['revoked' => true]);

        app('cookie')->queue(app('cookie')->forget('refresh_token'));

        $accessToken->revoke();

        return response()->json([
            'message' => '退出成功!'
        ], 204);
    }

    /**
     * 获取新的token
     *
     * @return $this
     */
    public function refresh()
    {
        $refreshToken = request()->cookie('refresh_token');

        $token = $this->tokenProxy
                      ->getToken('refresh_token', [
                          'refresh_token' => $refreshToken,
                      ]);

        return $this->response($token);
    }

    /**
     * 设置用户登录账号名
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }

    /**
     * 设置用户认证字段值
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * 返回值
     *
     * @param array $token
     * @return $this
     */
    protected function response(array $token)
    {
        // token数组
        $data = [
            'access_token' => $token['access_token'],
            'expires_in' => $token['expires_in']
        ];
        // 用户信息
        $userInfo = request()->user();
        if (! is_null($userInfo)) {
            $data = array_merge($data, [
                'id' => $userInfo->id,
                'name' => $userInfo->name,
                'email' => $userInfo->email,
                'avatar' => $userInfo->avatar,
                'avatar_thumb' => $userInfo->avatar_thumb,
            ]);
        }

        return response()->json(api_success_info('10000', '登录成功', $data))
                         ->cookie('refresh_token', $token['refresh_token'], 14400, null, null, false, true);
    }
}