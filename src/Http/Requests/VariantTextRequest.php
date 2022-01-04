<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantTextRequest extends FormRequest
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
            'id_variant_text' => 'numeric',            'fk_variant' => 'numeric',            'fk_lang' => 'numeric',            'designation_variant' => 'string|max:45',            'short_description_variant' => 'string|max:250',            'long_description_variant' => ''
        ];
    }
}

