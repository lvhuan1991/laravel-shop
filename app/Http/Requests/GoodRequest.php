<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //$id = $this->route('good') ? $this->route('good')->id : null;
        return [
            'title'=>'required',
            'list_pic'=>'required',
            'price'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'文章标题不能为空',
            'list_pic.required'=>'图片不能为空',
            'list_pic.unique'=>'图片已存在',
            'price.required'=>'请输入金额',
        ];
    }
}
