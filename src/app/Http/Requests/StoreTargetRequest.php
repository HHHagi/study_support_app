<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTargetRequest extends FormRequest
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
            'title' => 'required|max:100',
            'public_category_id' => 'required',
            'private_category_id' => 'required',
            'limit' => 'required',
            'is_private' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '目標を入力してください。',
            'title.max' => '１００文字以下で入力してください。',
            'public_category_id.required' => '一般カテゴリを入力してください。',
            'private_category_id.required' => 'マイカテゴリを入力してください。',
            'limit.required' => '目標期限を入力してください。',
            'is_private.required' => ' 公開・非公開を入力してください。',
        ];
    }
}
