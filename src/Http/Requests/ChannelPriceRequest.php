<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChannelPriceRequest extends FormRequest
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
            'id_channel_price' => 'numeric',            'fk_variant' => 'numeric',            'fk_price_category' => 'numeric',            'fk_channel' => 'numeric',            'price' => 'numeric',            'sale_price' => 'numeric',            'created_at' => 'string',            'updated_at' => 'string'
        ];
    }
}

