<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm|null $searchForm */
/** @var app\models\search\SearchPageModel $searchPageModel */

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\search\SearchModel;


$this->title = 'Search';
// $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/search', true)]);

$searchModel = $searchPageModel->searchModel;
$cardsWithGoods = $searchPageModel->cardsWithGoods;

if ($cardsWithGoods) {
    $itemPropertyNames = array_keys(get_object_vars($cardsWithGoods[0]));
    foreach ($cardsWithGoods as $itemCard) {
        // TODO create helper which encodes all properties of object
        // properties encoding to make code below clearer
        foreach ($itemPropertyNames as $propertyName) {
            $itemCard->$propertyName = Html::encode($itemCard->$propertyName);
        }
    }
}

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
                        <li class="item-card">
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
                <h3>
                    Goods with such a parameters were not found.
                </h3>

            <?php endif; ?>
        <?php endif ?>
    </section>
</div>