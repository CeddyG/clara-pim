<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
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
            'id_variant' => 'numeric',
            'fk_product' => 'numeric',
            'reference_variant' => 'string|max:45',
            'ean' => 'string|max:45',
            'stock_variant' => 'numeric',
            'created_at' => 'string',
            'updated_at' => 'string'
        ];
    }
}

