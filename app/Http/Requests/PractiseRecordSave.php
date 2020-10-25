<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PractiseRecordSave extends FormRequest
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
            'category_id' => 'required|int',
            'question_id' => '',  // optional param. If no practise_record, we must fill first question as the default later.
            'reply_answer' => '', // optional param. Only optional field for database.
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => '缺少参数question_id',
            'category_id.int' => '参数question_id格式不正确',
        ];
    }
}
