<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
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
            'name' => 'bail|required|string|max:255',
            'oldPassword' => 'bail|required|string|max:255',
            'newPassword' => 'bail|string|max:255',
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
            'name.required' => '账号名不能为空',
            'name.string' => '账号名格式不正确',
            'name.max' => '账号名最多255个字',
            'oldPassword.required' => '原密码不能为空',
            'oldPassword.string' => '原密码格式不正确',
            'oldPassword.max' => '原密码最多255个字符',
            'newPassword.string' => '新密码格式不正确',
            'newPassword.max' => '新密码最多255个字符',
        ];
    }
}
