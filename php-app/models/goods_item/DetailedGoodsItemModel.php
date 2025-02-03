<?php

namespace app\models\goods_item;

class DetailedGoodsItemModel extends \app\models\search\SearchItemCardModel {
    public ?string $description = null;
    public bool $isAlive;
    public bool $numberOfRemaining;
}