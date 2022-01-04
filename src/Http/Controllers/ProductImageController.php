<?php

namespace CeddyG\ClaraPim\Http\Controllers;

use Image;
use CeddyG\ClaraPim\Utils\Convert;
use CeddyG\ClaraPim\Repositories\ImageVariantTextRepository;

class ProductImageController extends Controller
{
    protected $oRepository;
    
    public function __construct(ImageVariantTextRepository $oImageVariantTextRepository)
    {
        $this->oRepository = $oImageVariantTextRepository;
    }
    
    public function show($sSize, $sSlug)
    {
        $oImageText = $this->oRepository
            ->findByField('slug_image_variant', $sSlug, ['fk_image_variant']);
        
        if (
            $oImageText->isEmpty() 
            || (
                !array_key_exists($sSize, config('clara.image-variant.size'))
                && $sSize != 'original'
            )
        )
        {
            return abort(404);
        }
        
        $sFile = storage_path('app/product'
            .Convert::intToCslashes($oImageText->first()->fk_image_variant)            
            .'/'.$oImageText->first()->fk_image_variant.'-'.$sSize.'.'.config('clara.image-variant.encode.extension')
        );
        
        return Image::make($sFile)->response();
    }
}
