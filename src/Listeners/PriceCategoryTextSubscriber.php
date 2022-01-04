<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\PriceCategoryTextRepository;

class PriceCategoryTextSubscriber
{
    private $oRepository;
    
    public function __construct(PriceCategoryTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\PriceCategoryTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['price_category_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_price_category'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_price_category', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_price_category', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\PriceCategory\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\PriceCategory\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\PriceCategory\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\PriceCategory\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\PriceCategory\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber@delete'
        );
    }
}
