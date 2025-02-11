<?php

use app\models\category\CategorizedItemCardModel;
use app\models\goods_item\DetailedGoodsItemModel;
use app\models\home\PopularItemCardModel;
use app\models\search\SearchItemCardModel;
use yii\bootstrap5\Html;

/** @var CategorizedItemCardModel|SearchItemCardModel|PopularItemCardModel $card */
/** @var string|null $categorySlug is required always (for detailed goods item page, in url). But when its value is a null, then $card->categorySlug is being assigned instead. */

$categorySlug ??= $card->categorySlug;

// TODO create helper which encodes all properties of object.
foreach ($card as $property => $value) {
    if (is_string($value)) {
        // properties encoding to make code below clearer
        $card->$property = Html::encode($value);
    }
}

?>

<?= Html::beginTag('li', ['class' => $liClass]) ?>
<img class="item-card-picture" src="<?= $card->mainPicture ?>" alt="the picture of <?= $card->name ?>">
<div>
    <strong>
        <?= Html::a($card->name, "/$categorySlug/$card->slug/$card->id") ?>
    </strong>

    <?php if (isset($card->category)): ?>
        <br>
        <?= Html::a($card->category, "/$categorySlug") ?>
    <?php endif; ?>

    <br>
    <!-- TODO create helper for this casting -->
    <?= "$card->atomicItemQuantity $card->atomicItemMeasure." ?>

    <br>
    <span class="price">
        <?php if ($card->priceOffer): ?>
            <span class="old-price"><?= $card->price ?> money</span>
            <span class="new-price"><?= $card->priceOffer ?> money</span>
            <span class="discount-percentage">-<?= $card->discountPercentage ?>%</span>

        <?php else: ?>
            <span class="ordinary-price"><?= $card->price ?> money</span>

        <?php endif; ?>
    </span>
</div>
<?= Html::endTag('li') ?>