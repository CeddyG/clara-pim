<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class VariantSupplierRepository extends QueryBuilderRepository
{
    protected $sTable = 'variant_supplier';

    protected $sPrimaryKey = 'id_variant_supplier';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'variant',
        'supplier'
    ];

    protected $aFillable = [
        'fk_variant',
        'fk_supplier',
        'gtin',
        'reference_supplier',
        'buying_price'
    ];
    
   
    public function variant()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\VariantRepository', 'fk_variant');
    }

    public function supplier()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\SupplierRepository', 'fk_supplier');
    }


}
