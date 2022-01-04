<?php

namespace CeddyG\ClaraPim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageVariantRequest extends FormRequest
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
    
    public function all($keys = null)
    {
        $aAttribute = parent::all($keys);
        
        if (
            $this->hasFile('file') 
            && $this->hasFile('fk_product') 
            && $this->hasFile('fk_product_category')
        )
        {
            $sName = $this->file('file')->getClientOriginalName();
            
            $aAttribute['url_library'] = 'storage/product/'.$aAttribute['fk_product_category'].'/'.$aAttribute['fk_product'].'/'.$sName;           
        }
        
        return $aAttribute;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_image_variant' => 'numeric',
            'fk_product' => 'numeric',
            'fk_variant' => 'numeric',
            'url_image_variant' => 'string|max:255'
        ];
    }
}

