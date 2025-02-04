<?php

/** @var yii\web\View $this */
/** @var app\models\home\HomePageModel $homePageModel */
/** @var app\models\home\PopularItemCardModel[] $cardsWithGoods */


use yii\helpers\Url;
use yii\bootstrap5\Html;

$this->title = 'Home';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/home', true)]);

$cardsWithGoods = $homePageModel->itemCardModels;

?>

<div id="home-page">
    <section id="popular-goods">
        <h1>POPULAR NOW</h1>
        <?php if (count($cardsWithGoods) > 0): ?>
            <ul id="popular-goods-list">
                <?php foreach ($cardsWithGoods as $itemCard): ?>
                    <li class="item-card popular">
                        <!-- TODO bind pictures -->
                        <img class="item-card-picture" src="/ladybug.jpg" alt="the picture of <?= $itemCard->name ?>">
                        <div>
                            <strong>
                                <?= Html::a($itemCard->name, "/$itemCard->categorySlug/$itemCard->slug/$itemCard->id") ?>
                            </strong>
                            <br>
                            <!-- TODO create helper for this casting -->
                            <?= "$itemCard->atomicItemQuantity  $itemCard->atomicItemMeasure." ?>
                            <br>
                            <?= Html::a($itemCard->category, "/$itemCard->categorySlug") ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
            <h3>Something went wrong.</h3>

        <?php endif; ?>
    </section>
</div>