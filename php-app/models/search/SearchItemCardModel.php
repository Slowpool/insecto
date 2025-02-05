<?php

namespace app\models\search;

use app\models\category\CategorizedItemCardModel;

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
class SearchItemCardModel extends CategorizedItemCardModel {
    public string $category;
    public string $categorySlug;
}