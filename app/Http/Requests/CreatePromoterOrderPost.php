<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePromoterOrderPost extends FormRequest
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
            'name' => 'required',
            'mobile' => [
                'required',
                'regex:/^1[34578][0-9]{9}$/'
            ],
            'gender' => 'required',
            'department_id' => 'required'
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
            'name.required' => '请输入姓名',
            'mobile.required' => '请输入手机号码',
            'mobile.regex' => '请输入正确的手机号码',
            'gender.required' => '请输入性别',
            'department_id.required' => '请输入部门',
        ];
    }
}
