<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use Storage;
use ClaraLang;
use CeddyG\ClaraPim\Utils\Convert;
use Illuminate\Support\Collection;

class ImageVariantRepository extends QueryBuilderRepository
{
    protected $sTable = 'image_variant';

    protected $sPrimaryKey = 'id_image_variant';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product',
        'variant',
        'image_variant_text',
        'image_variant_trans'
    ];

    protected $aFillable = [
        'fk_product',
        'fk_variant',
        'order_image_variant'
    ];
    
    /**
     * List of value that must have a default value when a record is stored.
     * 
     * @var array
     */
    protected $aDefaultCreate = [
        'order_image_variant'
    ];
    
    protected $aCustomAttribute = [
        'url' => [
            'image_variant_trans.slug_image_variant'
        ],
        'name' => [
            'image_variant_trans.name_image_variant'
        ],
        'alt' => [
            'image_variant_trans.alt_image_variant'
        ],
        'size' => [
            'id_image_variant'
        ]
    ];   
   
    public function product()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ProductRepository', 'fk_product');
    }

    public function variant()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\VariantRepository', 'fk_variant');
    }

    public function image_variant_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ImageVariantTextRepository', 'fk_image_variant');
    }
    
    public function image_variant_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ImageVariantTextRepository', 'fk_image_variant', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }

    public function getUrlAttribute($oItem)
    {
        $aUrl = [];
        
        if (!$oItem->image_variant_trans instanceof Collection)
        {
            $oItem->image_variant_trans = collect($oItem->image_variant_trans);
        }
        
        if ($oItem->image_variant_trans->isNotEmpty())
        {
            foreach (config('clara.image-variant.size') as $sSize => $iSize)
            {
                $aUrl[$sSize] = asset('product-image/'.$sSize.'/'.$oItem->image_variant_trans->first()->slug_image_variant);
            }
        }
        
        return $aUrl;
    }

    public function getNameAttribute($oItem)
    {
        return $oItem->image_variant_trans->first()->name_image_variant;
    }

    public function getAltAttribute($oItem)
    {
        return $oItem->image_variant_trans->first()->alt_image_variant;
    }
    
    public function getSizeAttribute($oItem)
    {
        $aSize  = [];        
        $aFiles = Storage::files('product'.Convert::intToCslashes($oItem->id_image_variant));
        
        if (!empty($aFiles))
        {
            preg_match('/^.*\.(.*)$/i', $aFiles[0], $aPreg);
            $sExtension = $aPreg[1];

            foreach (config('clara.image-variant.size') as $sSize => $iSize)
            {
                $aSize[$sSize] = Storage::size('product'
                    .Convert::intToCslashes($oItem->id_image_variant)
                    .'/'.$oItem->id_image_variant.'-'.$sSize.'.'.$sExtension
                );
            }
        }
        
        return $aSize;
    }
    
    public function setOrderImageVariantAttribute($aInputs)
    {
        if (array_key_exists('order_image_variant', $aInputs))
        {
            return $aInputs['order_image_variant'];
        }
        
        return array_key_exists('fk_product', $aInputs)
            ? $this->count([['fk_product', '=', $aInputs['fk_product']]])+1
            : 0;
    }
}
