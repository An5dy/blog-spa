<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class VerificationRequest extends FormRequest
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
            'email' => 'bail|required|string|email',
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
            'email.required' => '邮箱不能为空',
            'email.string' => '邮箱格式不正确',
            'email.email' => '邮箱格式不正确',
        ];
    }
}
