<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;

class ChannelRepository extends QueryBuilderRepository
{
    protected $sTable = 'channel';

    protected $sPrimaryKey = 'id_channel';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'channel_price',
        'channel_text',
        'channel_trans'
    ];

    protected $aFillable = [
        'code_channel'
    ];
    
    protected $bTimestamp = true;

   
    public function channel_price()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ChannelPriceRepository', 'fk_channel');
    }

    public function channel_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ChannelTextRepository', 'fk_channel');
    }

    public function channel_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\ChannelTextRepository', 'fk_channel', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }


}
