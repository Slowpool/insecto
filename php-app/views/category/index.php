<?php

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\category\CategorizedPageModel $categorizedPageModel */

$categorizedPageModel->categoryName = Html::encode($categorizedPageModel->categoryName);
$categorizedPageModel->categorySlug = Html::encode($categorizedPageModel->categorySlug);

$filter = $categorizedPageModel->filter;
$cardsWithGoods = $categorizedPageModel->cardsWithGoods;

$this->title = $categorizedPageModel->categoryName;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/category-page.js');

?>
<div id="category-page">
    <!-- TODO breadcrumbs -->
    <h3>
        <?= $this->title ?>
    </h3>
    <search id="insects-filter">
        <?php $filterForm = ActiveForm::begin([
            'id' => 'filter-form',
            'method' => 'get',
            'action' => "/$categorizedPageModel->categorySlug",
        ]) ?>
        <h3>Filter</h3>
        <?= $filterForm->field($filter, 'isAlive')->checkbox()->label('Is alive') ?>
        <?= $filterForm->field($filter, 'isAvailable')->checkbox()->label('Is available') ?>
        <section class="filter-price-limits">
            <?= $filterForm->field($filter, 'minPrice')->textInput(['type' => 'number', 'min' => '1', 'max' => strval(PHP_INT_MAX)])->label('Minimum price') ?>
            <?= $filterForm->field($filter, 'maxPrice')->textInput(['type' => 'number', 'min' => '1', 'max' => strval(PHP_INT_MAX)])->label('Maximum price') ?>
        </section>
        <?= Html::submitButton("Apply filter") ?>
        <?php ActiveForm::end() ?>
    </search>
    <section id="categorized-goods-area">
        <?php if ($cardsWithGoods): ?>
            <ul id="results-list">
                <?php foreach ($cardsWithGoods as $itemCard): ?>
                    <?= $this->render('@goods_item_card', ['liClass' => 'item-card categorized', 'card' => $itemCard, 'categorySlug' => $categorizedPageModel->categorySlug]) ?>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
            <h3>
                Nothing was found.
            </h3>

        <?php endif ?>
    </section>
</div>