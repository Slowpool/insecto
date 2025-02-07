<?php

namespace app\controllers;

use app\models\domain\GoodsClickStatisticsRecord;
use app\models\domain\UnitOfGoodsRecord;
use app\models\home\DiscountedItemCardModel;
use app\models\home\HomePageModel;
use app\models\home\PopularItemCardModel;
use app\models\search\SearchItemCardModel;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;

class HomeController extends BaseControllerWithCategories
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        GoodsClickStatisticsRecord::clear();
        $unitOfGoodsRecords = UnitOfGoodsRecord::findTheMostPopular(POPULAR_TO_DISPLAY);
        $popularGoodsCards = Yii::$app->automapper->mapMultiple($unitOfGoodsRecords, PopularItemCardModel::class);
        
        unset($unitOfGoodsRecord); // not necessary

        $unitOfGoodsRecords = UnitOfGoodsRecord::findDiscounted(DISCOUNTED_TO_DISPLAY);
        $discountedGoodsCards = Yii::$app->automapper->mapMultiple($unitOfGoodsRecords, DiscountedItemCardModel::class);

        $homePageModel = new HomePageModel($popularGoodsCards, $discountedGoodsCards);

        return $this->render('index', compact('homePageModel'));
    }
}
