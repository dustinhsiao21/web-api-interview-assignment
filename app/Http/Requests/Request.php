<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Only get data from rules
     *
     * @return array
     */
    public function onlyRules()
    {
        $fields = array_keys($this->rules());
        $fields = array_map(function ($field) {
            return strstr($field, '.*', true) ?: $field;
        }, $fields);
        return $this->only($fields);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
