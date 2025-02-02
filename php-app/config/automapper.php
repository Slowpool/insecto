<?php

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
    ->forMember('briefDescription', function (UnitOfGoodsRecord $record): string {
        return strlen($record->description) > BRIEF_DESC_MAX_LEN
            ? substr($record->description, 0, BRIEF_DESC_MAX_LEN)
            : $record->description;
    })
    // the following source properties technically aren't public properties - they are read via __get()
    ->forMember('name', ReadProperty('name'))
    ->forMember('price', ReadProperty('price'))
    ->forMember('atomicItemQuantity', ReadProperty('atomic_item_quantity'))
    ->forMember('atomicItemMeasure', ReadProperty('atomic_item_measure'))
    ->forMember('category', function($source) {
        return $source->category->name;
    })
;

return $autoMapperConfig;