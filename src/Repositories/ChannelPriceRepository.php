<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class ChannelPriceRepository extends QueryBuilderRepository
{
    protected $sTable = 'channel_price';

    protected $sPrimaryKey = 'id_channel_price';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'variant',
        'price_category',
        'channel'
    ];

    protected $aFillable = [
        'fk_variant',
        'fk_price_category',
        'fk_channel',
        'price',
        'sale_price'
    ];
    
    protected $bTimestamp = true;

   
    public function variant()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\VariantRepository', 'fk_variant');
    }

    public function price_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\PriceCategoryRepository', 'fk_price_category');
    }

    public function channel()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ChannelRepository', 'fk_channel');
    }


}
