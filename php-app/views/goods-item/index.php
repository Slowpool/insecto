<?php

/** @var yii\web\View $this */
/** @var app\models\goods_item\DetailedGoodsItemModel $goodsItemModel */

use yii\helpers\Url;
use yii\helpers\Html;

// TODO create helper which encodes all properties of object.
foreach ($goodsItemModel as $property => $value) {
    if (is_string($value)) {
        // properties encoding to make code below clearer
        $goodsItemModel->$property = Html::encode($value);
    }
}

$this->title = $goodsItemModel->name;
$this->params['breadcrumbs'][] = ['label' => $goodsItemModel->category, 'url' => "/$goodsItemModel->categorySlug"];

?>

<div id="goods-item-page">
    <h2><?= $this->title ?></h2>
    <h5>
        <?= Html::a($goodsItemModel->category, "/$goodsItemModel->categorySlug") ?>
    </h5>
    <img class="goods-item-picture" src="/ladybug.jpg" alt="Picture of <?= $goodsItemModel->name ?>">
    <br>
    <?= $goodsItemModel->description ?>
    <br>
    <b>Status:</b> <?= $goodsItemModel->isAlive ? "alive" : "dead" ?>
    <br>
    <b>Price:</b> <?= $goodsItemModel->price ?> money
    <br>
    <b>Remaining:</b> <?= $goodsItemModel->numberOfRemaining ?> item
    <br>
    <b>One goods item consists of:</b> <?= "$goodsItemModel->atomicItemQuantity  $goodsItemModel->atomicItemMeasure." ?>
    of <?= $goodsItemModel->name ?>
</div>