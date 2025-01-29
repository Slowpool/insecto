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

?>

<div id="search-page">
    <search>
        <?php $searchForm = ActiveForm::begin() ?>
        <?= $searchForm->field($searchModel, 'searchText')->textInput(['placeholder' => 'Search...']) ?>
        <?= $searchForm->field($searchModel, 'categories')->radioList(array_combine($categories, $categories)) ?>
        <?= $searchForm->field($searchModel, 'isAlive')->checkbox() ?>
        <?= $searchForm->field($searchModel, 'isAvailable')->checkbox() ?>
        <?= $searchForm->field($searchModel, 'minPrice')->textInput(['type' => 'number', 'placeholder' => '0', 'min' => '0', 'max' => strval(PHP_INT_MAX)]) ?>
        <?= $searchForm->field($searchModel, 'maxPrice')->textInput(['type' => 'number', 'placeholder' => strval(PHP_INT_MAX), 'min' => '0', 'max' => strval(PHP_INT_MAX)]) ?>

    </search>
</div>
