<?php

namespace CeddyG\ClaraPim\Listeners;

use File;
use Image;
use Storage;
use CeddyG\ClaraPim\Utils\Convert;
use CeddyG\ClaraPim\Repositories\ImageVariantRepository;

class ImageVariantSubscriber
{
    private $oRepository;
    
    public function __construct(ImageVariantRepository $oImageVariantRepository)
    {
        $this->oRepository = $oImageVariantRepository;
    }
    
    public function upload($oEvent)
    {
        if (isset($oEvent->aInputs['fileBlob']))
        {
            $sFolder = 'product'.Convert::intToCslashes($oEvent->id);
            $sFileOrigin = $oEvent->id.'-original.'.$oEvent->aInputs['fileBlob']->extension();
            
            $oEvent->aInputs['fileBlob']->storeAs(
                $sFolder, 
                $sFileOrigin
            );
            
            foreach(config('clara.image-variant.size') as $sSize => $iSize)
            {
                $sFile = $oEvent->id.'-'.$sSize.'.'.$oEvent->aInputs['fileBlob']->extension();
                
                $oEvent->aInputs['fileBlob']->storeAs(
                    $sFolder, 
                    $sFile
                );
                
                Image::make(storage_path('app/'.$sFolder.'/'.$sFile))
                    ->encode(
                        $oEvent->aInputs['fileBlob']->extension(), 
                        config('clara.image-variant.encode.quality')
                    )
                    ->widen($iSize)
                    ->save();
            }
        }
    }
    
    public function delete($oEvent)
    {
        $this->reorder($oEvent);
        
        $this->removeFromDirectory($oEvent);
    }
    
    protected function reorder($oEvent)
    {
        $oImageVariant = $this->oRepository->find($oEvent->id, ['fk_product']);
        
        $oImageVariants = $this->oRepository->orderBy('order_image_variant')->findWhere(
            [
                ['fk_product', '=', $oImageVariant->fk_product],
                ['id_image_variant', '!=', $oImageVariant->id_image_variant]
            ], 
            ['id_image_variant']
        );        
        
        $oImageVariants->each(function ($oItem, $iKey) {
            $this->oRepository->update(
                $oItem->id_image_variant, 
                ['order_image_variant' => $iKey+1]
            );
        });
    }
    
    public function syncVariant($oEvent)
    {
        foreach ($oEvent->aInputs['image_variant'] as $iIdImageVariant)
        {
            $this->oRepository->update(
                $iIdImageVariant, 
                ['fk_variant' => $oEvent->id]
            );
        }
    }
    
    protected function removeFromDirectory($oEvent)
    {
        $sFolder = 'product'.Convert::intToCslashes($oEvent->id);
        
        File::delete(
            File::glob(
                storage_path('app/'.$sFolder.'/'.$oEvent->id.'-*')
            )
        );
        
        if (empty(Storage::directories($sFolder)) && empty(Storage::files($sFolder)))
        {
            Storage::deleteDirectory($sFolder);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantSubscriber@upload'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantSubscriber@upload'
        );

        $oEvent->listen(
            'CeddyG\ClaraPim\Events\ImageVariant\BeforeDestroyEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantSubscriber@delete'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterStoreEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantSubscriber@syncVariant'
        );
        
        $oEvent->listen(
            'CeddyG\ClaraPim\Events\Variant\AfterUpdateEvent',
            'CeddyG\ClaraPim\Listeners\ImageVariantSubscriber@syncVariant'
        );
    }
}
