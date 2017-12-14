<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FriendlyLinkRequest extends FormRequest
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
            'description' => 'bail|required|string|max:255',
            'path' => 'bail|required|url|max:255',
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
            'description.required' => '链接描述不能为空',
            'description.string' => '链接描述格式不正确',
            'description.max' => '链接描述最多255个字',
            'path.required' => '链接不能为空',
            'path.url' => '链接格式不正确',
            'path.max' => '链接最多255个字',
        ];
    }
}
