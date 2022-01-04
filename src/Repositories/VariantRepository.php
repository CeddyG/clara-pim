<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class VariantRepository extends QueryBuilderRepository
{
    protected $sTable = 'variant';

    protected $sPrimaryKey = 'id_variant';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product',
        'channel_price',
        'image_variant',
        'attribute',
        'variant_supplier',
        'variant_text'
    ];

    protected $aFillable = [
        'fk_product',
        'reference_variant',
        'ean',
        'stock_variant'
    ];
    
    protected $bTimestamp = true;

   
    public function product()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ProductRepository', 'fk_product');
    }

    public function channel_price()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ChannelPriceRepository', 'fk_variant');
    }

    public function image_variant()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ImageVariantRepository', 'fk_variant');
    }

    public function attribute()
    {
        return $this->belongsToMany('CeddyG\ClaraPim\Repositories\AttributeRepository', 'variant_attribute', 'fk_variant', 'fk_attribute');
    }

    public function variant_supplier()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\VariantSupplierRepository', 'fk_variant');
    }

    public function variant_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\VariantTextRepository', 'fk_variant');
    }


}
