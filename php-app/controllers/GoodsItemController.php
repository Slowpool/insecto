<?php

use app\models\domain\UnitOfGoodsRecord;
use yii\web\Controller;
use yii\filters\VerbFilter;

class GoodsItemController extends Controller {
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
                    'send-contact-us-form' => ['post'],
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

    public function actionIndex(string $categorySlug, string $goodsSlug, int $goodsId) {
        // TODO should i use special GoodsItemSearchModel-like class here?
        $goodsItem = UnitOfGoodsRecord::searchOne($categorySlug, $goodsSlug, $goodsId);
    }
}