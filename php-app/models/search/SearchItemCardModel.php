<?php

namespace app\models\search;

use app\models\category\CategorizedItemCardModel;

class SearchItemCardModel extends CategorizedItemCardModel {
    public string $category;
    public string $categorySlug;
}