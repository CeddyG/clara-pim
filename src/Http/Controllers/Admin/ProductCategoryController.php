<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use CeddyG\ClaraPim\Repositories\ProductCategoryRepository;

class ProductCategoryController extends ContentManagerController
{
    protected $sEventBeforeStore    = \CeddyG\ClaraPim\Events\ProductCategory\BeforeStoreEvent::class;
    protected $sEventAfterStore     = \CeddyG\ClaraPim\Events\ProductCategory\AfterStoreEvent::class;
    protected $sEventBeforeUpdate   = \CeddyG\ClaraPim\Events\ProductCategory\BeforeUpdateEvent::class;
    protected $sEventAfterUpdate    = \CeddyG\ClaraPim\Events\ProductCategory\AfterUpdateEvent::class;
    protected $sEventBeforeDestroy  = \CeddyG\ClaraPim\Events\ProductCategory\BeforeDestroyEvent::class;
    protected $sEventAfterDestroy   = \CeddyG\ClaraPim\Events\ProductCategory\AfterDestroyEvent::class;

    public function __construct(ProductCategoryRepository $oRepository)
    {
        $this->sPath            = 'admin/product-category';
        $this->sPathRedirect    = 'admin/product-category';
        $this->sName            = __('product-category.product_category');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraPim\Http\Requests\ProductCategoryRequest';
    }
}
