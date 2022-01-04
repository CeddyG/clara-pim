<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\AttributeCategoryTextRepository;

class AttributeCategoryTextSubscriber
{
    private $oRepository;
    
    public function __construct(AttributeCategoryTextRepository $oRepository)
    {
        $this->oRepository = $oRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\AttributeCategoryTextRequest');
    }

    public function store($oEvent) 
    {
        $aInputs = $oEvent->aInputs['attribute_category_text'];
        
        foreach ($aInputs as $iIdLang => $aInput)
        {
            $aInput['fk_lang'] = $iIdLang;
            $aInput['fk_attribute_category'] = $oEvent->id;
            
            $this->oRepository->updateOrCreate(
                [
                    ['fk_lang', '=', $iIdLang],
                    ['fk_attribute_category', '=', $oEvent->id]
                ], 
                $aInput
            );
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_attribute_category', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\AttributeCategory\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\AttributeCategory\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\AttributeCategory\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\AttributeCategory\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\AttributeCategory\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber@delete'
        );
    }
}
