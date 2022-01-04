<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\VariantSupplierRepository;

class VariantSupplierSubscriber
{
    private $oRepository;
    
    public function __construct(VariantSupplierRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\VariantSupplierRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['variant_supplier'];
        
        foreach ($aInputs as $iIdSupplier => $aInput)
        {
            $aInput['fk_supplier'] = $iIdSupplier;
            $aInput['fk_variant'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_supplier', '=', $iIdSupplier],
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
            'CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber@delete'
        );
    }
}
