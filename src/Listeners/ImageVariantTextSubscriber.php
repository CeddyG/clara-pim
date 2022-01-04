<?php

namespace CeddyG\ClaraPim\Listeners;

use CeddyG\ClaraPim\Repositories\ProductTextRepository;
use CeddyG\ClaraPim\Repositories\ImageVariantRepository;
use CeddyG\ClaraPim\Repositories\ImageVariantTextRepository;

class ImageVariantTextSubscriber
{
    private $oRepository;
    private $oProductTextRepository;
    private $oImageVariantRepository;
    
    public function __construct(
        ImageVariantTextRepository $oRepository, 
        ProductTextRepository $oProductTextRepository,
        ImageVariantRepository $oImageVariantRepository
    )
    {
        $this->oRepository              = $oRepository;
        $this->oProductTextRepository   = $oProductTextRepository;
        $this->oImageVariantRepository  = $oImageVariantRepository;
    }
    
    public function validate($oEvent) 
    {
        app('CeddyG\ClaraPim\Http\Requests\ImageVariantTextRequest');
    }

    public function store($oEvent) 
    {
        if (array_key_exists('image_variant_text', $oEvent->aInputs))
        {
            $aInputs = $oEvent->aInputs['image_variant_text'];
        }
        elseif (array_key_exists('fk_product', $oEvent->aInputs))
        {
            $aTexts = $this->oProductTextRepository
                ->findByField('fk_product', $oEvent->aInputs['fk_product']);
            
            $iCount = $this->oImageVariantRepository
                ->count([['fk_product', '=', $oEvent->aInputs['fk_product']]]);
            
            foreach ($aTexts as $oText)
            {
                $aInputs[$oText->fk_lang] = [
                    'name_image_variant'    => $oText->designation_product,
                    'slug_image_variant'    => $oText->slug_product.'-'.$iCount.'.'.config('clara.image-variant.encode.extension'),
                    'alt_image_variant'     => $oText->designation_product
                ];
            }
        }
        
        if (isset($aInputs))
        {
            foreach ($aInputs as $iIdLang => $aInput)
            {
                $aInput['fk_lang'] = $iIdLang;
                $aInput['fk_image_variant'] = $oEvent->id;

                $this->oRepository->updateOrCreate(
                    [
                        ['fk_lang', '=', $iIdLang],
                        ['fk_image_variant', '=', $oEvent->id]
                    ], 
                    $aInput
                );
            }
        }
    }
    
    public function delete($oEvent)
    {
        $this->oRepository->deleteWhere([['fk_image_variant', '=', $oEvent->id]]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\BeforeStoreEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber@validate'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\BeforeUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber@validate'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber@store'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber@delete'
        );
    }
}
