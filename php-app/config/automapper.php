<?php

use app\models\domain\GoodsCategoryRecord;
use app\models\goods_item\DetailedGoodsItemModel;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\ItemCardModel;
use AutoMapperPlus\MappingOperation\Operation;

$autoMapperConfig = new AutoMapperConfig;

function ReadProperty($propertyName)
{
    return Operation::mapFrom(function ($source) use ($propertyName): mixed {
        return $source->$propertyName;
    });
}

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, ItemCardModel::class)
    ->forMember('id', ReadProperty('id'))
    ->forMember('description', ReadProperty('description'))
    // the following source properties technically aren't public properties - they are read via __get()
    ->forMember('name', ReadProperty('name'))
    ->forMember('slug', ReadProperty('slug'))
    ->forMember('price', ReadProperty('price'))
    ->forMember('atomicItemQuantity', ReadProperty('atomic_item_quantity'))
    ->forMember('atomicItemMeasure', ReadProperty('atomic_item_measure'))
;

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, DetailedGoodsItemModel::class)
    ->copyFrom(UnitOfGoodsRecord::class, ItemCardModel::class)
    ->forMember('isAlive', ReadProperty('is_alive'))
    ->forMember('numberOfRemaining', ReadProperty('number_of_remaining'))
;

$autoMapperConfig->registerMapping(GoodsCategoryRecord::class, ItemCardModel::class)
    ->forMember('category', ReadProperty('name'))
    ->forMember('categorySlug', ReadProperty('slug'))
;

return $autoMapperConfig;