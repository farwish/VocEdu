<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionIndex extends FormRequest
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
            'cid' => 'required|int'
        ];
    }

    public function messages()
    {
        return [
            'cid.required' => '缺少参数cid', // chapter.id
            // 'cid.int' => '参数cid格式不正确',
        ];
    }
}
