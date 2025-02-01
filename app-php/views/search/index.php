<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $searchForm */
/** @var app\models\search\SearchPageModel $searchPageModel */

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\search\SearchModel;


$this->title = 'Search';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/insects', true)]);
$this->registerJsFile('@web/js/search.js');

$searchModel = $searchPageModel->searchModel;
$cardsWithGoods = $searchPageModel->cardsWithGoods;

// sorting of ['cats' => true, 'dogs' => false, 'chickens' => false]
// in the following way:
// categoryItems = ['cats' => 'cats', 'dogs' => 'dogs', 'chickens' => 'chickens']
// checkedCategories = ['cats']
$categoryNames = array_keys($searchModel->categories);
$categoryItems = array_combine($categoryNames, $categoryNames);
$checkedCategories = array_keys($searchModel->categories, true);
$searchModel->categories = $checkedCategories;

// properties encoding to make code below clearer
if ($cardsWithGoods) {
    $itemPropertyNames = array_keys(get_object_vars($cardsWithGoods[0]));
    foreach ($cardsWithGoods as $itemCard) {
        foreach ($itemPropertyNames as $propertyName) {
            $itemCard->$propertyName = Html::encode($itemCard->$propertyName);
        }
    }
}

?>

<div id="search-page">
    <search id="insects-search">
        <?php $searchForm = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'action' => '/insects' . ($searchModel->categories
                ? '/' . implode('/', $searchModel->categories)
                : '')
        ]) ?>
        <?= $searchForm->field($searchModel, 'searchText')->textInput(['placeholder' => 'Search...']) ?>
        <section class="search-categories">
            <?= $searchForm->field($searchModel, 'categories')->checkboxList($categoryItems, ['itemOptions' => ['class' => 'form-check-input search-category-checkbox']])->label('Categories (when no one is selected = everyone is selected)') ?>
        </section>
        <?= $searchForm->field($searchModel, 'isAlive')->checkbox(/*['uncheck' => null]*/)->label('Is alive') ?>
        <?= $searchForm->field($searchModel, 'isAvailable')->checkbox(/*['uncheck' => null]*/)->label('Is available') ?>
        <section class="search-price-limits">
            <?= $searchForm->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'placeholder' => '0', 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Minimum price') ?>
            <?= $searchForm->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'placeholder' => strval(PHP_INT_MAX), 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Maximum price') ?>
        </section>
        <?= Html::submitButton("Search") ?>
        <?php ActiveForm::end() ?>
    </search>
    <section id="results-of-search">
        <h3>Results of search (<?= count($cardsWithGoods) ?>)</h3>
        <?php if ($cardsWithGoods): ?>
            <ul id="results-list">
                <?php foreach ($cardsWithGoods as $itemCard): ?>
                    <li class="item-card">
                        <!-- TODO bind pictures -->
                        <img class="item-card-picture" href="/ladybug.jpg" alt="the picture of <?= $itemCard->name ?>">
                        <div>
                            <strong>
                                <?= $itemCard->name ?>
                            </strong>
                            <br>
                            <?= $itemCard->briefDescription ?>
                            <br>
                            <?= "$itemCard->atomicItemQuantity  $itemCard->atomicItemMeasure." ?>
                            <br>
                            <?= Html::a($itemCard->category, "/insects/$itemCard->category") ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            Goods with such a parameters are not found.
        <?php endif ?>
    </section>
</div>