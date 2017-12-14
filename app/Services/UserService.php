<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiErrorException;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 获取用户列表
     *
     * @return mixed
     */
    public function list(Request $request)
    {
        $users = $this->userRepository
                      ->scopeQuery(function ($query) use ($request){
                          return $query->name($request->search);
                      })
                      ->paginate(null, ['id', 'name', 'email', 'avatar_thumb', 'status', 'created_at']);

        return $users;
    }

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

    /**
     * 禁止用户登录
     *
     * @param $id
     * @return mixed
     */
    public function toggleBan($id)
    {
        try {
            $user = $this->userRepository->find($id);
            $status = $user->status == 1 ? 0 : 1;
            $user->update(['status' => $status]);

            return api_success_info('10000', '操作成功', ['status' => $status]);
        } catch (\Exception $exception) {

            return api_error_info('20000', '操作失败');
        }
    }
}