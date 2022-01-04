<?php

namespace CeddyG\ClaraPim\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use CeddyG\ClaraPim\Repositories\ImageVariantRepository;

class ImageVariantController extends ContentManagerController
{
    protected $sEventBeforeStore    = \CeddyG\ClaraPim\Events\ImageVariant\BeforeStoreEvent::class;
    protected $sEventAfterStore     = \CeddyG\ClaraPim\Events\ImageVariant\AfterStoreEvent::class;
    protected $sEventBeforeUpdate   = \CeddyG\ClaraPim\Events\ImageVariant\BeforeUpdateEvent::class;
    protected $sEventAfterUpdate    = \CeddyG\ClaraPim\Events\ImageVariant\AfterUpdateEvent::class;
    protected $sEventBeforeDestroy  = \CeddyG\ClaraPim\Events\ImageVariant\BeforeDestroyEvent::class;
    protected $sEventAfterDestroy   = \CeddyG\ClaraPim\Events\ImageVariant\AfterDestroyEvent::class;

    public function __construct(ImageVariantRepository $oRepository)
    {
        $this->sPath            = 'admin/image-variant';
        $this->sPathRedirect    = 'admin/image-variant';
        $this->sName            = __('image-variant.image_variant');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraPim\Http\Requests\ImageVariantRequest';
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {   
        $oRequest   = app($this->sRequest);
        $aInputs    = $oRequest->all();
        
        if ($this->sEventBeforeStore != '')
        {
            event(new $this->sEventBeforeStore($aInputs));
        }
        
        $id = $this->oRepository->create($aInputs);
        
        if ($this->sEventAfterStore != '')
        {
            event(new $this->sEventAfterStore($id, $aInputs));
        }
        
        if (!$oRequest->is('api/*'))
        {
            return redirect($this->sPathRedirect)->withOk("L'objet a été créé.");
        }
        else
        {
            $oImage = $this->oRepository->find($id, ['image_variant_trans.*', 'url', 'size']);
            
            return response()->json([
                'message'   => 'Ok',
                'id'        => $id,
                'input'     => $aInputs,
                'initialPreview' => [
                    asset('product-image/medium/'.$oImage->image_variant_trans->first()->slug_image_variant)
                ], // initial preview configuration 
                'initialPreviewConfig' => [
                    [
                        'key' => $id,
                        'caption' => $oImage->image_variant_trans->first()->name_image_variant,
                        'size' => $oImage->size['medium'],
                        'downloadUrl' => $oImage->url['medium'],
                        'url' => route('api.admin.image-variant.destroy', $oImage->id_image_variant),
                    ]
                ],
                'initialPreviewAsData' => true
            ], 200);
        }
    }
}
