<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'id_product' => 'numeric',            'fk_product_category' => 'numeric',            'reference_product' => 'string|max:45',            'type_product' => 'numeric',            'created_at' => 'string',            'updated_at' => 'string'
        ];
    }
}

