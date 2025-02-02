<?php

namespace app\models\search;

class ItemCardModel {
    public int $id;
    public string $name;
    public string $slug;
    public int $price;
    public string $briefDescription;
    public int $atomicItemQuantity;
    public string $atomicItemMeasure;
    public string $category;
    public string $categorySlug;
}