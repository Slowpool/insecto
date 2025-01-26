<?php

/** @var yii\web\View $this */
/** @var string $content */

?>

<?php $this->beginContent('@layouts/main.php') ?>

<div class="two-column">
    <?= $this->render('//partial/categories_nav', ['categoriesModel' => $this->params['categoriesModel']]) ?>
    <div id="nested-main">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent() ?>