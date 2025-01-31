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

// sorting of ['cats' => true, 'dogs' => false, 'chickens' => false]
// in the following way:
// categoryItems = ['cats' => 'cats', 'dogs' => 'dogs', 'chickens' => 'chickens']
// checkedCategories = ['cats']
$categoryNames = array_keys($searchModel->categories);
$categoryItems = array_combine($categoryNames, $categoryNames);
$checkedCategories = array_keys($searchModel->categories, true);
$searchModel->categories = $checkedCategories;

// simplifying access to category name. just to simplify the code in further
foreach ($searchPageModel->cardsWithGoods as &$card) {
    $card['category'] = $card['category']['name'];
}
unset($card);

?>

<div id="search-page">
    <search id="insects-search">
        <?php $searchForm = ActiveForm::begin(['id' => 'search-form', 'method' => 'get']) ?>
        <?= $searchForm->field($searchModel, 'searchText')->textInput(['placeholder' => 'Search...']) ?>
        <section class="search-categories">
            <?= $searchForm->field($searchModel, 'categories')->checkboxList($categoryItems, ['itemOptions' => ['class' => 'form-check-input search-category-checkbox']]) ?>
        </section>
        <?= $searchForm->field($searchModel, 'isAlive')->checkbox()->label('Is alive') ?>
        <?= $searchForm->field($searchModel, 'isAvailable')->checkbox()->label('Is available') ?>
        <section class="search-price-limits">
            <?= $searchForm->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'placeholder' => '0', 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Minimum price') ?>
            <?= $searchForm->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'placeholder' => strval(PHP_INT_MAX), 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Maximum price') ?>
        </section>
        <?= Html::submitButton("Search") ?>
        <?php ActiveForm::end() ?>
    </search>
    <section id="results-of-search">
        <h3>Results of search</h3>
        <?php if ($searchPageModel->cardsWithGoods): ?>
            <ul id="results-list">
                <?php foreach ($searchPageModel->cardsWithGoods as $itemCard): ?>
                    <li class="item-card">
                        <!-- TODO bind pictures -->
                        <img class="item-card-picture" href="/ladybug.jpg" alt="the picture of <?= $itemCard->name ?>">
                        <div>
                            <?= $itemCard->name ?>
                            <br>
                            <?= $itemCard->briefDescription ?>
                            <br>
                            <?= "$itemCard->atomic_item_quantity  $itemCard->atomic_item_measure." ?>
                            <br>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            Goods with such a parameters are not found.
        <?php endif ?>
    </section>
</div>