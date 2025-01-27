<?php

/** @var yii\web\View $this */
/** @var string $content */

?>

<?php $this->beginContent('@layouts/main.php') ?>

<div class="two-column">
<!-- TODO I forgot why i made partial view here -->
    <?= $this->render('//partial/categories_nav') ?>
    <div id="nested-main">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent() ?>