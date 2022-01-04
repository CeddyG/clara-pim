<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class ChannelTextRepository extends QueryBuilderRepository
{
    protected $sTable = 'channel_text';

    protected $sPrimaryKey = 'id_channel_text';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'channel'
    ];

    protected $aFillable = [
        'fk_channel',
        'fk_lang',
        'name_channel'
    ];
    
   
    public function channel()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\ChannelRepository', 'fk_channel');
    }


}
