<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class AttributeCategoryTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'attribute_category_text';

    protected $sPrimaryKey = 'id_attribute_category_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'attribute_category'
    ];

    protected $aFillable = [
        'fk_attribute_category',
        'fk_lang',
        'name_attribute_category'
    ];
    
    protected $bTimestamp = true;

   
    public function attribute_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\AttributeCategoryRepository', 'fk_attribute_category');
    }


}
