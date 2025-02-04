<?php

namespace app\models\search;

use app\models\search\SearchModel;

// this model doesn't need validation => no `Model` inheritance
class SearchPageModel {
    public SearchModel $searchModel;
    /**
     * @var SearchItemCardModel[]
     */
    public array|null $cardsWithGoods;
    public function __construct(SearchModel $searchModel, array|null $cardsWithGoods) {
        $this->searchModel = $searchModel;
        $this->cardsWithGoods = $cardsWithGoods;
    }
}