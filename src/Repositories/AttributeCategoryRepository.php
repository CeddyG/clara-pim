<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;

class AttributeCategoryRepository extends QueryBuilderRepository
{
    protected $sTable = 'attribute_category';

    protected $sPrimaryKey = 'id_attribute_category';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'attribute',
        'attribute_category_text'
    ];

    protected $aFillable = [
        'created_at',
        'updated_at'
    ];
    
    protected $aCustomAttribute = [
        'name' => [
            'attribute_category_trans.name_attribute_category'
        ]
    ];
    
    protected $bTimestamp = true;

   
    public function attribute()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\AttributeRepository', 'fk_attribute_category');
    }

    public function attribute_category_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\AttributeCategoryTextRepository', 'fk_attribute_category');
    }
    
    public function attribute_category_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\AttributeCategoryTextRepository', 'fk_attribute_category', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }

    public function getNameAttribute($oItem)
    {
        return $oItem->attribute_category_trans->first()->name_attribute_category;
    }
}
