<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionNoteSave extends FormRequest
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
            'qid' => 'required',
            'note' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'qid.required' => '缺少参数qid',
            'note.required' => '缺少参数note',
        ];
    }
}
