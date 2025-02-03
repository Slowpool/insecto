<?php

namespace app\models\category;

use app\models\category\CommonCategorizedFilter;

class CategorizedPageModel
{
    public string $categoryName;
    public string $categorySlug;
    public CommonCategorizedFilter $filter;
    /** @var \app\models\search\SearchItemCardModel[] $cardsWithGoods */
    public array $cardsWithGoods;
    public function __construct(string $categoryName, string $categorySlug, CommonCategorizedFilter $filter, array $cardsWithGoods) {
        $this->categoryName = $categoryName;
        $this->categorySlug = $categorySlug;
        $this->filter = $filter;
        $this->cardsWithGoods = $cardsWithGoods;
    }
}