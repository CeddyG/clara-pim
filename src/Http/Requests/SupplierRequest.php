<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'id_supplier' => 'numeric',            'code_supplier' => 'string|max:255',            'name_supplier' => 'string|max:255',            'adress_supplier' => 'string|max:255',            'zip_supplier' => 'string|max:255',            'city_supplier' => 'string|max:255',            'email_supplier' => 'string|max:255'
        ];
    }
}

