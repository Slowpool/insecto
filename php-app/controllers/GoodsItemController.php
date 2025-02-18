<?php

namespace app\controllers;

use app\models\domain\GoodsClickStatisticsRecord;
use Yii;

use app\models\domain\UnitOfGoodsRecord;
use yii\filters\VerbFilter;
use app\models\goods_item\DetailedGoodsItemModel;
use yii\web\NotFoundHttpException;

class GoodsItemController extends BaseControllerWithCategories
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [

        ];
    }

    public function actionIndex(string $categorySlug, string $goodsSlug, int $goodsItemId)
    {
        $goodsItemRecord = UnitOfGoodsRecord::searchOne($categorySlug, $goodsSlug, $goodsItemId);
        if ($goodsItemRecord === null) {
            throw new NotFoundHttpException('Such a goods item not found');
        }
        GoodsClickStatisticsRecord::registerClick($goodsItemRecord->id, false);
        $goodsItemModel = Yii::$app->automapper->map($goodsItemRecord, DetailedGoodsItemModel::class);
        return $this->render('index', compact('goodsItemModel'));
    }
}