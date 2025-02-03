<?php

/** @var yii\web\View $this */
/** @var app\models\category\CategoryModel $category */
/** @var string $content */

use yii\bootstrap5\Html;
use yii\helpers\Url;

?>

<?php $this->beginContent('@layouts/main.php') ?>

<div class="two-column">
    <nav id="categories-nav">
        <h4>Categories of insects</h4>
        <ul id="categories-nav-list">
            <?php
            /** @var app\models\category\CategoryModel $category */
            foreach ($this->params['categoriesModel'] as $category): ?>
                <li>
                    <?= Html::a(Html::encode($category->name), Html::encode("/$category->slug")) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
    <div id="nested-main">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent() ?>