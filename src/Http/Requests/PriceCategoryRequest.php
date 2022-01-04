<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceCategoryRequest extends FormRequest
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
            'id_price_category' => 'numeric',            'created_at' => 'string',            'updated_at' => 'string'
        ];
    }
}

