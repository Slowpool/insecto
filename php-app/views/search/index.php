<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm|null $searchForm */
/** @var app\models\search\SearchPageModel $searchPageModel */

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\search\SearchModel;


$this->title = 'Search';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/search', true)]);

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

const MAX_DESCRIPTION_LEN = 80;
if ($cardsWithGoods) {
    $itemPropertyNames = array_keys(get_object_vars($cardsWithGoods[0]));
    foreach ($cardsWithGoods as $itemCard) {
        // TODO create helper which encodes all properties of object
        // properties encoding to make code below clearer
        foreach ($itemPropertyNames as $propertyName) {
            $itemCard->$propertyName = Html::encode($itemCard->$propertyName);
        }
        // shortening the long descriptions
        $itemCard->description = strlen($itemCard->description) > MAX_DESCRIPTION_LEN
            ? substr($itemCard->description, 0, MAX_DESCRIPTION_LEN)
            : $itemCard->description;
    }
}

?>


<div id="search-page">
    <h3>
        <?= Html::encode($this->title) ?>
    </h3>
    <search id="insects-search">
        <?php $searchForm = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'action' => '/search' . ($searchModel->categories
                ? '/' . implode('/', $searchModel->categories)
                : '')
        ]) ?>
        <?= $searchForm->field($searchModel, 'searchText')->textInput(['placeholder' => 'Search...']) ?>
        <section class="search-categories">
            <?= $searchForm->field($searchModel, 'categories')->checkboxList($categoryItems, ['itemOptions' => ['class' => 'form-check-input search-category-checkbox']])->label('Categories (when no one is selected = everyone is selected)') ?>
        </section>
        <?= $searchForm->field($searchModel, 'isAlive')->checkbox()->label('Is alive') ?>
        <?= $searchForm->field($searchModel, 'isAvailable')->checkbox()->label('Is available') ?>
        <section class="search-price-limits">
            <?= $searchForm->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Minimum price') ?>
            <?= $searchForm->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'min' => '0', 'max' => strval(PHP_INT_MAX)])->label('Maximum price') ?>
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
                        <img class="item-card-picture" src="/ladybug.jpg" alt="the picture of <?= $itemCard->name ?>">
                        <div>
                            <strong>
                                <?= Html::a($itemCard->name, "/insect/$itemCard->categorySlug/$itemCard->slug/$itemCard->id") ?>
                            </strong>
                            <br>
                            <?= $itemCard->description ?>
                            <br>
                            <!-- TODO create helper for this casting -->
                            <?= "$itemCard->atomicItemQuantity  $itemCard->atomicItemMeasure." ?>
                            <br>
                            <?= Html::a($itemCard->category, "/insects/$itemCard->category") ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
            <h3>
                Goods with such a parameters are not found.
            </h3>

        <?php endif ?>
    </section>
</div>