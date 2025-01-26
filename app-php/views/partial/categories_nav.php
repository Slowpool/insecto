<?php

/** @var yii\web\View $this */
/** @var array $categoriesModel */

use yii\bootstrap5\Html;

?>

<nav id="categories-nav">
    <h4>Categories of goods</h4>
    <ul>
        <?php foreach ($categoriesModel as $categoryName => $categoryUrl): ?>
            <li>
                <?= Html::a(Html::encode($categoryName), Html::encode($categoryUrl)) ?>
            </li>
        <?php endforeach ?>
    </ul>
</nav>