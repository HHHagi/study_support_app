<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaRequest extends FormRequest
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
            'idea' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'idea.required' => '考察を入力してください。',
            'idea.string' => '考察は文字列で入力してください。',
        ];
    }
}
