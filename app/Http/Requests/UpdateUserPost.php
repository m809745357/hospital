<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'sometimes|required',
            'name' => 'sometimes|required',
            'mobile' => [
                'sometimes',
                'required',
                'regex:/^1[34578][0-9]{9}$/'
            ],
            'card' => 'sometimes|required'
        ];
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.required' => '请输入医院床号',
            'name.required' => '请输入用户姓名',
            'mobile.required' => '请输入手机号码',
            'mobile.regex' => '请输入正确的手机号码',
            'card.required' => '请输入身份证号码',
        ];
    }
}
