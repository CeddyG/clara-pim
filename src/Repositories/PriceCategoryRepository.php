<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;

class PriceCategoryRepository extends QueryBuilderRepository
{
    protected $sTable = 'price_category';

    protected $sPrimaryKey = 'id_price_category';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'channel_price',
        'price_category_text',
        'price_category_trans'
    ];

    protected $aFillable = [
        'created_at',
        'updated_at'
    ];
    
    protected $bTimestamp = true;

   
    public function channel_price()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ChannelPriceRepository', 'fk_price_category');
    }

    public function price_category_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\PriceCategoryTextRepository', 'fk_price_category');
    }

    public function price_category_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\PriceCategoryTextRepository', 'fk_price_category', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }


}
