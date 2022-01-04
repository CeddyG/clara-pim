<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class ProductTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'product_text';

    protected $sPrimaryKey = 'id_product_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'product'
    ];

    protected $aFillable = [
        'fk_product',
        'fk_lang',
        'designation_product',
        'slug_product'
    ];
    
   
    public function product()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ProductRepository', 'fk_product');
    }


}
