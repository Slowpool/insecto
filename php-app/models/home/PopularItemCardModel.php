<?php

namespace app\models\home;

use app\models\search\SearchItemCardModel;

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
 */
class PopularItemCardModel extends SearchItemCardModel {
    // here could be some properties in future
}