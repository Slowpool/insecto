<?php

/** @var yii\web\View $this */
/** @var string $categoryName */

use yii\bootstrap5\Html;
use yii\helpers\Url;

?>

<nav id="categories-nav">
    <h4>Categories of insects</h4>
    <ul>
        <?php foreach ($this->params['categoriesModel'] as $categoryName): ?>
            <li>
                <?= Html::a(Html::encode($categoryName), Url::to('/insects/' . Html::encode($categoryName))) ?>
            </li>
        <?php endforeach ?>
    </ul>
</nav>