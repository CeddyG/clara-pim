<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class PriceCategoryTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'price_category_text';

    protected $sPrimaryKey = 'id_price_category_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'price_category'
    ];

    protected $aFillable = [
        'fk_price_category',
        'fk_lang',
        'name_price_category'
    ];
    
   
    public function price_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\PriceCategoryRepository', 'fk_price_category');
    }


}
