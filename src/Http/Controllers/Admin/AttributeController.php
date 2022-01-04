<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use Illuminate\Http\Request;
use CeddyG\ClaraPim\Repositories\AttributeRepository;

class AttributeController extends ContentManagerController
{
    protected $sEventBeforeStore    = \CeddyG\ClaraPim\Events\Attribute\BeforeStoreEvent::class;
    protected $sEventAfterStore     = \CeddyG\ClaraPim\Events\Attribute\AfterStoreEvent::class;
    protected $sEventBeforeUpdate   = \CeddyG\ClaraPim\Events\Attribute\BeforeUpdateEvent::class;
    protected $sEventAfterUpdate    = \CeddyG\ClaraPim\Events\Attribute\AfterUpdateEvent::class;
    protected $sEventBeforeDestroy  = \CeddyG\ClaraPim\Events\Attribute\BeforeDestroyEvent::class;
    protected $sEventAfterDestroy   = \CeddyG\ClaraPim\Events\Attribute\AfterDestroyEvent::class;

    public function __construct(AttributeRepository $oRepository)
    {
        $this->sPath            = 'admin/attribute';
        $this->sPathRedirect    = 'admin/attribute';
        $this->sName            = __('attribute.attribute');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraPim\Http\Requests\AttributeRequest';
    }
    
    public function edit($id, Request $oRequest)
    {
        if (!$oRequest->is('api/*'))
        {
            $oItem = $this->oRepository
                ->getFillFromView($this->sPath.'/form', ['attribute_category'])
                ->find($id, ['attribute_category.name']);

            $sPageTitle = $this->sName;

            return view($this->sPath.'/form',  compact('oItem','sPageTitle'));
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
