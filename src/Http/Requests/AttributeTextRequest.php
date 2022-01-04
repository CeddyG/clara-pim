<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeTextRequest extends FormRequest
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
            'id_attribute_text' => 'numeric',            'fk_attribute' => 'numeric',            'fk_lang' => 'numeric',            'name_attribute' => 'string|max:45',            'created_at' => 'string',            'updated_at' => 'string'
        ];
    }
}

