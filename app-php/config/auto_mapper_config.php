<?php

use AutoMapperPlus\Configuration\AutoMapperConfig;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\ItemCardModel;

$autoMapperConfig = new AutoMapperConfig;
$autoMapperConfig->registerMapping(UnitOfGoodsRecord::class, ItemCardModel::class)
    ->forMember('briefDescription', function (string $description): string {
        return strlen($description) > BRIEF_DESC_MAX_LEN
            ? substr($description, 0, BRIEF_DESC_MAX_LEN)
            : $description;
    });

return $autoMapperConfig;