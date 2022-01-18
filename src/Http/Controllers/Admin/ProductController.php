<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use Illuminate\Http\Request;
use CeddyG\ClaraPim\Repositories\ProductRepository;
use CeddyG\ClaraPim\Repositories\AttributeCategoryRepository;
use CeddyG\ClaraPim\Repositories\ChannelRepository;
use CeddyG\ClaraPim\Repositories\SupplierRepository;
use CeddyG\ClaraPim\Repositories\PriceCategoryRepository;

class ProductController extends ContentManagerController
{
    protected $sEventBeforeStore    = \CeddyG\ClaraPim\Events\Product\BeforeStoreEvent::class;
    protected $sEventAfterStore     = \CeddyG\ClaraPim\Events\Product\AfterStoreEvent::class;
    protected $sEventBeforeUpdate   = \CeddyG\ClaraPim\Events\Product\BeforeUpdateEvent::class;
    protected $sEventAfterUpdate    = \CeddyG\ClaraPim\Events\Product\AfterUpdateEvent::class;
    protected $sEventBeforeDestroy  = \CeddyG\ClaraPim\Events\Product\BeforeDestroyEvent::class;
    protected $sEventAfterDestroy   = \CeddyG\ClaraPim\Events\Product\AfterDestroyEvent::class;
    
    protected $oAttributeCategoryRepository;
    protected $oChannelRepository;
    protected $oPriceCategoryRepository;

    public function __construct(
        ProductRepository $oRepository, 
        AttributeCategoryRepository $oAttributeCategoryRepository,
        ChannelRepository $oChannelRepository,
        SupplierRepository $oSupplierRepository,
        PriceCategoryRepository $oPriceCategoryRepository
    )
    {
        $this->sPath            = 'clara-pim::admin/product';
        $this->sPathRedirect    = 'admin/product';
        $this->sName            = __('clara-pim::product.product');
        
        $this->oRepository                      = $oRepository;
        $this->oAttributeCategoryRepository     = $oAttributeCategoryRepository;
        $this->oChannelRepository               = $oChannelRepository;
        $this->oSupplierRepository              = $oSupplierRepository;
        $this->oPriceCategoryRepository         = $oPriceCategoryRepository;
        $this->sRequest                         = 'CeddyG\ClaraPim\Http\Requests\ProductRequest';
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $oRequest)
    {
        if (!$oRequest->is('api/*'))
        {
            return view(
                $this->sPath.'/form',  
                [
                    'oItem' => $this->oRepository
                        ->getFillFromView($this->sPath.'/form')
                        ->find($id, ['product_category.name']), 
                    'oAttributeCategories' => $this->oAttributeCategoryRepository->all(
                        [
                            'attribute_category_trans.name_attribute_category', 
                            'attribute.attribute_trans.name_attribute'
                        ]
                    ), 
                    'oChannels' => $this->oChannelRepository
                        ->all(['code_channel', 'channel_trans.name_channel']),
                    'oSuppliers' => $this->oSupplierRepository
                        ->all(['code_supplier', 'name_supplier']),
                    'oPriceCategories' => $this->oPriceCategoryRepository
                        ->all(['price_category_trans.name_price_category']),
                    'sPageTitle' => $this->sName
                ]
            );
        }
        else
        {
            $aInput = $oRequest->all();
            
            if (array_has($aInput, 'column') && count($aInput['column']) > 0)
            {
                $aField = $aInput['column'];
            }
            else
            {
                $aField = ['*'];
            }
            
            $oItem = $this->oRepository
                ->find($id, $aField);
            
            return response()->json($oItem, 200);
        }
    }
}
