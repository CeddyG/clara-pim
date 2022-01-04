<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryTextRequest extends FormRequest
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
            'id_product_category_text' => 'numeric',            'fk_product_category' => 'numeric',            'fk_lang' => 'numeric',            'name_product_category' => 'string|max:90'
        ];
    }
}

