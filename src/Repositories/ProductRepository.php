<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;
use Illuminate\Support\Collection;

class ProductRepository extends QueryBuilderRepository
{
    protected $sTable = 'product';

    protected $sPrimaryKey = 'id_product';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product_category',
        'product_text',
        'product_trans',
        'variant',
        'image_variant'
    ];

    protected $aFillable = [
        'fk_product_category',
        'reference_product',
        'type_product'
    ];
    
    protected $aCustomAttribute = [
        'designation' => [
            'product_trans.designation_product'
        ]
    ];
    
    protected $bTimestamp = true;

   
    public function product_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ProductCategoryRepository', 'fk_product_category');
    }

    public function product_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ProductTextRepository', 'fk_product');
    }

    public function product_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ProductTextRepository', 'fk_product', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }

    public function variant()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\VariantRepository', 'fk_product');
    }
    
    public function image_variant()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ImageVariantRepository', 'fk_product');
    }

    public function getDesignationAttribute($oItem)
    {
        return $oItem->product_trans->first()->designation_product;
    }
    
    public function getImageVariantRelation($oItem)
    {        
        if (!$oItem->image_variant instanceof Collection)
        {
            $oItem->image_variant = collect($oItem->image_variant);
        }
        
        return $oItem->image_variant->sortBy('order_image_variant');
    }
}
