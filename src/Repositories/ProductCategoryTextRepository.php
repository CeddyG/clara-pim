<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class ProductCategoryTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'product_category_text';

    protected $sPrimaryKey = 'id_product_category_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product_category'
    ];

    protected $aFillable = [
        'fk_product_category',
        'fk_lang',
        'name_product_category'
    ];
    
   
    public function product_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ProductCategoryRepository', 'fk_product_category');
    }


}
