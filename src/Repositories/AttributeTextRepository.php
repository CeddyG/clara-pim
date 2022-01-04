<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class AttributeTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'attribute_text';

    protected $sPrimaryKey = 'id_attribute_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'attribute'
    ];

    protected $aFillable = [
        'fk_attribute',
        'fk_lang',
        'name_attribute'
    ];
    
    protected $bTimestamp = true;

   
    public function attribute()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\AttributeRepository', 'fk_attribute');
    }
}
