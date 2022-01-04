<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTextRequest extends FormRequest
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
            'id_product_text' => 'numeric',            'fk_product' => 'numeric',            'fk_lang' => 'numeric',            'designation_product' => 'string|max:90',            'slug_product' => 'string|max:90'
        ];
    }
}

