<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class SupplierRepository extends QueryBuilderRepository
{
    protected $sTable = 'supplier';

    protected $sPrimaryKey = 'id_supplier';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'variant'
    ];

    protected $aFillable = [
        'code_supplier',
        'name_supplier',
        'adress_supplier',
        'zip_supplier',
        'city_supplier',
        'email_supplier'
    ];
    
   
    public function variant()
    {
        return $this->belongsToMany('CeddyG\ClaraPim\Repositories\VariantRepository', 'variant_supplier', 'fk_supplier', 'fk_variant');
    }


}
