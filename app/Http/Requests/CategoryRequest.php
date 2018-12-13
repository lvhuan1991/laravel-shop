<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();//或者是return true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('category') ? $this->route('category')->id :null;
        //required必须要填不能为空unique唯一不能重复
        return [
            'name'=>'required|unique:categories,name,' . $id,
            'pid'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'请输入栏目名称',
            'name.unique'=>'栏目名称已存在',
            'pid.required'=>'请选择所属栏目',
        ];
    }

}
