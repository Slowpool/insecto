<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm|null $searchForm */
/** @var app\models\search\SearchPageModel $searchPageModel */

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\search\SearchModel;


$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/search', true)]);

$searchModel = $searchPageModel->searchModel;
$cardsWithGoods = $searchPageModel->cardsWithGoods;

?>

<div id="search-page">
    <h3>
        Search everywhere
    </h3>
    <search id="insects-search">
        <?php $searchForm = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'action' => '/search',
        ]) ?>
        <?= $searchForm->field($searchModel, 'q')->textInput(['placeholder' => 'Search...'])->label('What are we looking for?') ?>
        <?= Html::submitButton("Search") ?>
        <?php ActiveForm::end() ?>
    </search>
    <section id="results-of-search">
        <?php if ($cardsWithGoods !== null): ?>
            <?php if (count($cardsWithGoods) > 0): ?>
                <h3>Results of search (<?= count($cardsWithGoods) ?>)</h3>
                <ul id="results-list">
                    <?php foreach ($cardsWithGoods as $itemCard): ?>
                        <?= $this->render('@goods_item_card', ['liClass' => 'item-card', 'card' => $itemCard]) ?>
                    <?php endforeach; ?>
                </ul>

            <?php else: ?>
                <h3>
                    Goods with such a parameters were not found.
                </h3>

            <?php endif; ?>
        <?php endif ?>
    </section>
</div>