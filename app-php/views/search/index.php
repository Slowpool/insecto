<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $searchForm */
/** @var app\models\search\SearchPageModel $searchPageModel */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\search\SearchModel;


$this->title = 'Search';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/insects', true)]); 

$searchModel = $searchPageModel->searchModel;

$categoryNames = array_keys($searchModel->categories);
$categoryItems = array_combine($categoryNames, $categoryNames);

// simplifying access to category name. just to simplify the code in further
foreach($searchPageModel->cardsWithGoods as &$card) {
    $card['category'] = $card['category']['name'];
}
unset($card);


?>

div id = search-page is below
<div id="search-page">
    search tag is below
    <search>
        search tag is above
        <?php $searchForm = ActiveForm::begin() ?>
        <?= $searchForm->field($searchModel, 'searchText')->textInput(['placeholder' => 'Search...']) ?>
        <section class="search-categories">
            <?= $searchForm->field($searchModel, 'categories')->checkboxList($categoryItems) ?>
        </section>
        <?= $searchForm->field($searchModel, 'isAlive')->checkbox() ?>
        <?= $searchForm->field($searchModel, 'isAvailable')->checkbox() ?>
        <section class="search-price-limits">
            <?= $searchForm->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'placeholder' => '0', 'min' => '0', 'max' => strval(PHP_INT_MAX)]) ?>
            <?= $searchForm->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'placeholder' => strval(PHP_INT_MAX), 'min' => '0', 'max' => strval(PHP_INT_MAX)]) ?>
        </section>
    </search>
</div>
