<?php

namespace App\Http\Requests;

use App\Exceptions\ApiErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ArticleRequest extends FormRequest
{
    /**
     * 自定义错误信息
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
            'title' => 'bail|required|string|max:255',
            'description' => 'bail|required|string',
            'tags' => 'bail|array|between:1, 5',
            'category' => 'bail|required|integer',
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
            'title.required' => '文章标题不能为空',
            'title.string' => '文章标题必须为字符串',
            'title.max' => '文章标题字符必须小于256个字符',
            'description.required' => '文章正文不能为空',
            'description.string' => '文章正文必须为字符串',
            'tags.array' => '文章标签必须为数组',
            'tags.between' => '文章标签个数不正确',
            'category.required' => '文章类别不能为空',
            'category.integer' => '文章类别ID必须为整型',
        ];
    }
}
