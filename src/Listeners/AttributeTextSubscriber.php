<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\AttributeTextRepository;

class AttributeTextSubscriber
{
    private $oRepository;
    
    public function __construct(AttributeTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\AttributeTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['attribute_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_attribute'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_attribute', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_attribute', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Attribute\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\AttributeTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Attribute\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\AttributeTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Attribute\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\AttributeTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Attribute\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\AttributeTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Attribute\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\AttributeTextSubscriber@delete'
        );
    }
}
