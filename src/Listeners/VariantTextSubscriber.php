<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\VariantTextRepository;

class VariantTextSubscriber
{
    private $oRepository;
    
    public function __construct(VariantTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\VariantTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['variant_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_variant'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_variant', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_variant', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\VariantTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\VariantTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\VariantTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\VariantTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\VariantTextSubscriber@delete'
        );
    }
}
