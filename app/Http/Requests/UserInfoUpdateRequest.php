<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserInfoUpdateRequest extends FormRequest
{
    /**
     * 错去提示
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
            'avatar' => 'url',
            'avatar_thumb' => 'required_with:avatar|url',
            'name' => 'string|max:255'
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
            'avatar.url' => '头像地址必须为有效的url地址',
            'avatar_thumb.url' => '压缩头像地址必须为有效的url地址',
            'avatar_thumb.required_with' => '压缩头像地址不能为空',
            'name.string' => '姓名格式不正确',
            'name.max' => '姓名最多255个字符',
        ];
    }
}
