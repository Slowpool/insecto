<?php

namespace app\models\category;

class CategorizedItemCardModel {
    public int $id;
    public string $name;
    public string $slug;
    public int $price;
    public int $atomicItemQuantity;
    public string $atomicItemMeasure;
}