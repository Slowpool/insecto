<?php

/** @var yii\web\View $this */
/** @var app\models\home\HomePageModel $homePageModel */
/** @var app\models\home\PopularItemCardModel[] $popularGoodsCards */
/** @var app\models\home\DiscountedItemCardModel[] $discountedGoodsCards */


use yii\helpers\Url;
use yii\bootstrap5\Html;

$this->title = 'Home';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/home', true)]);

$popularGoodsCards = $homePageModel->popularGoodsCards;
$discountedGoodsCards = $homePageModel->discountedGoodsCards;

?>

<div id="home-page">
    <?php if (count($popularGoodsCards) > 0): ?>
        <section id="popular-goods">
            <h1>POPULAR NOW</h1>
            <ul id="popular-goods-list">
                <?php foreach ($popularGoodsCards as $itemCard): ?>
                    <?= $this->render('@goods_item_card', ['liClass' => 'item-card popular', 'card' => $itemCard]) ?>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
    <?php if (count($discountedGoodsCards) > 0): ?>
        <section id="offers">
            <h1>HELLY OFFERS</h1>
            <ul id="popular-goods-list">
                <?php foreach ($discountedGoodsCards as $itemCard): ?>
                    <?= $this->render('@goods_item_card', ['liClass' => 'item-card discounted', 'card' => $itemCard]) ?>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
</div>