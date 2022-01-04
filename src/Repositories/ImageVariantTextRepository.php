<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class ImageVariantTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'image_variant_text';

    protected $sPrimaryKey = 'id_image_variant_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'image_variant'
    ];

    protected $aFillable = [
        'fk_image_variant',
        'fk_lang',
        'name_image_variant',
        'slug_image_variant',
        'alt_image_variant'
    ];
   
    public function image_variant()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ImageVariantRepository', 'fk_image_variant');
    }


}
