<?php

/** @var yii\web\View $this */
/** @var app\models\goods_item\DetailedGoodsItemModel $goodsItemModel */

use yii\helpers\Url;
use yii\helpers\Html;

// TODO create helper which encodes all properties of object
foreach ($goodsItemModel as $propertyName => $_) {
    $goodsItemModel->$propertyName = Html::encode($goodsItemModel->$propertyName);
}

$this->title = $goodsItemModel->name;

?>
<!-- TODO breadcrumbs -->

<div id="goods-item-page">
    <h3><?= $this->title ?></h3>
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
    <b>One goods item consists of:</b> <?= "$goodsItemModel->atomicItemQuantity  $goodsItemModel->atomicItemMeasure." ?> of <?= $goodsItemModel->name ?>
</div>