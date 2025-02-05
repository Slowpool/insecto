<?php

namespace app\models\home;

/**
 * Summary of HomePageModel
 * @property PopularItemCardModel[] $popularGoodsCards
 * @property DiscountedItemCardModel[] $discountedGoodsCards
 */
class HomePageModel {
    public array $popularGoodsCards;
    public array $discountedGoodsCards;
    public function __construct(array $popularGoodsCards, array $discountedGoodsCards) {
        $this->popularGoodsCards = $popularGoodsCards;
        $this->discountedGoodsCards = $discountedGoodsCards;

    }
}