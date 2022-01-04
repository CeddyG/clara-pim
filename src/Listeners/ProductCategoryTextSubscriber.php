<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\ProductCategoryTextRepository;

class ProductCategoryTextSubscriber
{
    private $oRepository;
    
    public function __construct(ProductCategoryTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\ProductCategoryTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['product_category_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_product_category'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_product_category', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_product_category', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ProductCategory\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ProductCategory\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ProductCategory\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ProductCategory\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ProductCategory\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber@delete'
        );
    }
}
