<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageVariantTextRequest extends FormRequest
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
            'id_image_variant_text' => 'numeric',            'fk_image_variant' => 'numeric',            'fk_lang' => 'numeric',            'name_image_variant' => 'string|max:255',            'slug_image_variant' => 'string|max:255',            'alt_image_variant' => 'string|max:255'
        ];
    }
}

