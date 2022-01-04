<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            'id_attribute' => 'numeric',            'fk_attribute_category' => 'numeric',            'created_at' => 'string',            'updated_at' => 'string'
        ];
    }
}

