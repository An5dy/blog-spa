<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * 错误信息
     *
     * @param Validator $validator
     * @throws ApiErrorException
     */
    public function failedValidation(Validator $validator)
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
            'password' => 'bail|required|string|min:6|confirmed',
            'oldPassword' => 'bail|required|string|min:6'
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
            'password.required' => '新密码不能为空',
            'password.string' => '新密码格式不正确',
            'password.min' => '新密码最少6位',
            'password.confirmed' => '两次密码输入不一致',
            'oldPassword.required' => '旧密码不能为空',
            'oldPassword.string' => '旧密码格式不正确',
            'oldPassword.min' => '旧密码最少6位',
        ];
    }
}
