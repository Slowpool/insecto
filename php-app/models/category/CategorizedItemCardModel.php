<?php

namespace app\models\category;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $price
 * @property ?int $priceOffer
 * @property ?int $discountPercentage
 * @property int $atomicItemQuantity
 * @property string $atomicItemMeasure
 * @property ?string $mainPicture
 */
class CategorizedItemCardModel {
    public int $id;
    public string $name;
    public string $slug;
    public int $price;
    public ?int $priceOffer = null;
    public ?int $discountPercentage = null;
    public int $atomicItemQuantity;
    public string $atomicItemMeasure;
    public ?string $mainPicture;
}