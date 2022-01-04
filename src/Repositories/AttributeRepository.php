<?php

namespace CeddyG\ClaraPim\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

use App;
use ClaraLang;

class AttributeRepository extends QueryBuilderRepository
{
    protected $sTable = 'attribute';

    protected $sPrimaryKey = 'id_attribute';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    protected $aRelations = [
        'attribute_category',
        'attribute_text',
        'attribute_trans',
        'variant'
    ];

    protected $aFillable = [
        'fk_attribute_category'
    ];
    
    protected $aCustomAttribute = [
        'name' => [
            'attribute_trans.name_attribute'
        ]
    ];
    
    protected $bTimestamp = true;

   
    public function attribute_category()
    {
        return $this->belongsTo('CeddyG\ClaraPim\Repositories\AttributeCategoryRepository', 'fk_attribute_category');
    }

    public function attribute_text()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\AttributeTextRepository', 'fk_attribute');
    }

    public function attribute_trans()
    {
        return $this->hasMany('CeddyG\ClaraPim\Repositories\AttributeTextRepository', 'fk_attribute', [['fk_lang', '=', ClaraLang::getIdByCode(App::getLocale())]]);
    }

    public function variant()
    {
        return $this->belongsToMany('CeddyG\ClaraPim\Repositories\VariantRepository', 'variant_attribute', 'fk_attribute', 'fk_variant');
    }

    public function getNameAttribute($oItem)
    {
        return $oItem->attribute_trans->first()->name_attribute;
    }
}
