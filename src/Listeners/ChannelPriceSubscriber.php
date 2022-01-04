<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\ChannelPriceRepository;

class ChannelPriceSubscriber
{
    private $oRepository;
    
    public function __construct(ChannelPriceRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\ChannelPriceRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['channel_price'];
        
        foreach ($aInputs as $iIdChannel => $aCategory)
        {
            foreach ($aCategory as $iIdCategory => $aInput)
            {
                $aInput['fk_channel']           = $iIdChannel;
                $aInput['fk_price_category']    = $iIdCategory;
                $aInput['fk_variant']           = $oEvent->id;

                $this->oRepository->updateOrCreate(
                    [
                        ['fk_channel', '=', $iIdChannel],
                        ['fk_price_category', '=', $iIdCategory],
                        ['fk_variant', '=', $oEvent->id]
                    ], 
                    $aInput
                );
            }
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
            'CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber@delete'
        );
    }
}
