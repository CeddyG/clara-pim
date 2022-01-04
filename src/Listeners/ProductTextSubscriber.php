<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\ProductTextRepository;

class ProductTextSubscriber
{
    private $oRepository;
    
    public function __construct(ProductTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\ProductTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['product_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_product'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_product', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_product', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Product\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\ProductTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Product\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ProductTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Product\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ProductTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Product\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ProductTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Product\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ProductTextSubscriber@delete'
        );
    }
}
