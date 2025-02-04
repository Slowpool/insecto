<?php

use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\MappingOperation\Operation;

use app\models\category\CategorizedItemCardModel;
use app\models\category\CategoryModel;

use app\models\domain\GoodsCategoryRecord;
use app\models\domain\UnitOfGoodsRecord;

use app\models\goods_item\DetailedGoodsItemModel;
use app\models\home\PopularItemCardModel;
use app\models\search\SearchItemCardModel;

$autoMapperConfig = new AutoMapperConfig;

function ReadProperty($propertyName)
{
    return Operation::mapFrom(function ($source) use ($propertyName): mixed {
        return $source->$propertyName;
    });
}

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, CategorizedItemCardModel::class)
    // the following source properties technically aren't public properties - they are read via __get()
    ->forMember('id', ReadProperty('id'))
    ->forMember('name', ReadProperty('name'))
    ->forMember('slug', ReadProperty('slug'))
    ->forMember('price', ReadProperty('price'))
    ->forMember('atomicItemQuantity', ReadProperty('atomic_item_quantity'))
    ->forMember('atomicItemMeasure', ReadProperty('atomic_item_measure'))
;

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, SearchItemCardModel::class)
    ->copyFrom(UnitOfGoodsRecord::class, CategorizedItemCardModel::class)
    ->forMember('category', Operation::mapFrom(function ($record) {
        return $record->category->name;
    }))
    ->forMember('categorySlug', Operation::mapFrom(function ($record) {
        return $record->category->slug;
    }))
;

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, DetailedGoodsItemModel::class)
    ->copyFrom(UnitOfGoodsRecord::class, SearchItemCardModel::class)
    ->forMember('description', ReadProperty('description'))
    ->forMember('isAlive', ReadProperty('is_alive'))
    ->forMember('numberOfRemaining', ReadProperty('number_of_remaining'))
;

$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, PopularItemCardModel::class)
    ->copyFrom(UnitOfGoodsRecord::class, SearchItemCardModel::class)
;

$autoMapperConfig->registerMapping(GoodsCategoryRecord::class, CategoryModel::class)
    ->forMember('name', ReadProperty('name'))
    ->forMember('slug', ReadProperty('slug'))
;

return $autoMapperConfig;