<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ImageRequest extends FormRequest
{
    /**
     * @param Validator $validator
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
            'image' => 'bail|required|image|max:1048576'
        ];
    }

    /**
     * 自定义错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.required' => '上传图片不能为空',
            'image.image' => '上传图片必须是一个图像',
            'image.max' => '上传图片必须1M'
        ];
    }
}
