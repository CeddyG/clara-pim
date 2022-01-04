<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use CeddyG\ClaraPim\Repositories\SupplierRepository;

class SupplierController extends ContentManagerController
{
    public function __construct(SupplierRepository $oRepository)
    {
        $this->sPath            = 'admin/supplier';
        $this->sPathRedirect    = 'admin/supplier';
        $this->sName            = __('supplier.supplier');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraPim\Http\Requests\SupplierRequest';
    }
}
