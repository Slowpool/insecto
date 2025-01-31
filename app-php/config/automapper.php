<?php

use AutoMapperPlus\Configuration\AutoMapperConfig;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\ItemCardModel;
use AutoMapperPlus\MappingOperation\Operation;

$autoMapperConfig = new AutoMapperConfig;
$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, ItemCardModel::class)
    ->forMember('briefDescription', function (UnitOfGoodsRecord $record): string {
        return strlen($record->description) > BRIEF_DESC_MAX_LEN
            ? substr($record->description, 0, BRIEF_DESC_MAX_LEN)
            : $record->description;
    })
    ->forMember('name', Operation::fromProperty('name'))
    ->forMember('price', Operation::fromProperty('price'))
    ->forMember('atomic_item_quantity', Operation::fromProperty('atomic_item_quantity'))
    ->forMember('atomic_item_measure', Operation::fromProperty('atomic_item_measure'))
    ;

return $autoMapperConfig;