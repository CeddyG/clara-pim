<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use CeddyG\ClaraPim\Repositories\PriceCategoryRepository;

class PriceCategoryController extends ContentManagerController
{
    protected $sEventBeforeStore    = \CeddyG\ClaraPim\Events\PriceCategory\BeforeStoreEvent::class;
    protected $sEventAfterStore     = \CeddyG\ClaraPim\Events\PriceCategory\AfterStoreEvent::class;
    protected $sEventBeforeUpdate   = \CeddyG\ClaraPim\Events\PriceCategory\BeforeUpdateEvent::class;
    protected $sEventAfterUpdate    = \CeddyG\ClaraPim\Events\PriceCategory\AfterUpdateEvent::class;
    protected $sEventBeforeDestroy  = \CeddyG\ClaraPim\Events\PriceCategory\BeforeDestroyEvent::class;
    protected $sEventAfterDestroy   = \CeddyG\ClaraPim\Events\PriceCategory\AfterDestroyEvent::class;

    public function __construct(PriceCategoryRepository $oRepository)
    {
        $this->sPath            = 'admin/price-category';
        $this->sPathRedirect    = 'admin/price-category';
        $this->sName            = __('price-category.price_category');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraPim\Http\Requests\PriceCategoryRequest';
    }
}
