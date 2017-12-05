<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * 重写错误返回信息
     *
     * @param Validator $validator
     * @throws ApiErrorException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ApiErrorException($validator->errors()->first(), '20000');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'captchaCode' => 'bail|required|string',
            'password' => 'bail|required|string|min:6|confirmed',
        ];
    }

    /**
     * 自定义错误
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.string' => '用户名格式不正确',
            'username.max' => '用户名过长',
            'email.required' => '邮箱不能为空',
            'email.string' => '邮箱格式不正确',
            'email.email' => '邮箱格式不正确',
            'email.max' => '邮箱过长',
            'email.unique' => '邮箱已存在',
            'captchaCode.required' => '验证码不能为空',
            'captchaCode.string' => '验证码格式不正确',
            'password.required' => '密码不能为空',
            'password.string' => '密码格式不正确',
            'password.min' => '密码最少6位',
            'password.confirmed' => '两次密码输入不一致',
        ];
    }
}
