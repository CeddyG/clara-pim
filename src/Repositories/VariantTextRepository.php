<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class VariantTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'variant_text';

    protected $sPrimaryKey = 'id_variant_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'variant'
    ];

    protected $aFillable = [
        'fk_variant',
        'fk_lang',
        'designation_variant',
        'short_description_variant',
        'long_description_variant'
    ];
    
   
    public function variant()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\VariantRepository', 'fk_variant');
    }


}
