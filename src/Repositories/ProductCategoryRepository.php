<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;

class ProductCategoryRepository extends QueryBuilderRepository
{
    protected $sTable = 'product_category';

    protected $sPrimaryKey = 'id_product_category';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product',
        'product_category_text',
        'product_category_trans'
    ];

    protected $aFillable = [
        'created_at',
        'updated_at'
    ];
    
    protected $aCustomAttribute = [
        'name' => [
            'product_category_trans.name_product_category'
        ]
    ];
    
    protected $bTimestamp = true;

   
    public function product()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ProductRepository', 'fk_product_category');
    }

    public function product_category_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ProductCategoryTextRepository', 'fk_product_category');
    }

    public function product_category_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ProductCategoryTextRepository', 'fk_product_category', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }

    public function getNameAttribute($oItem)
    {
        return $oItem->product_category_trans->first()->name_product_category;
    }
}
