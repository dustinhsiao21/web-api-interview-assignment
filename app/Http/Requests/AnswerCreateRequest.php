<?php

namespace App\Http\Requests;

class AnswerCreateRequest extends Request
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
            'patient_id' => 'required|int',
            'question_id' => 'required|int',
            'answers' => 'required|array',
        ];
    }
}
