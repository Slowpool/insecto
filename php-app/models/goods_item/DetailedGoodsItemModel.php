<?php

namespace app\models\goods_item;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $price
 * @property ?int $priceOffer
 * @property int $atomicItemQuantity
 * @property string $atomicItemMeasure
 * @property string $category
 * @property string $categorySlug
 * @property ?string $description
 * @property bool $isAlive
 * @property int $numberOfRemaining
 */
class DetailedGoodsItemModel extends \app\models\search\SearchItemCardModel
{
    public ?string $description = null;
    public bool $isAlive;
    public int $numberOfRemaining;
}