<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantSupplierRequest extends FormRequest
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
            'fk_variant' => 'numeric',            'fk_supplier' => 'numeric',            'gtin' => 'string|max:255',            'reference_supplier' => 'string|max:255',            'buying_price' => 'numeric'
        ];
    }
}

