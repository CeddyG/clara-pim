<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\ChannelTextRepository;

class ChannelTextSubscriber
{
    private $oRepository;
    
    public function __construct(ChannelTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\ChannelTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['channel_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_channel'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_channel', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_channel', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Channel\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\ChannelTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Channel\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ChannelTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Channel\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ChannelTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Channel\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ChannelTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Channel\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ChannelTextSubscriber@delete'
        );
    }
}
