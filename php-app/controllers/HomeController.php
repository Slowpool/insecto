<?php

namespace app\controllers;

use app\models\domain\GoodsClickStatisticsRecord;
use app\models\domain\UnitOfGoodsRecord;
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
                    // TODO fill

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
        // TODO now 5 is a max number (for demonstration purpose), but it can be edited.
        $unitOfGoodsRecords = UnitOfGoodsRecord::findTheMostPopular(5);
        $cardsWithGoods = Yii::$app->automapper->mapMultiple($unitOfGoodsRecords, PopularItemCardModel::class);
        
        $homePageModel = new HomePageModel($cardsWithGoods);

        return $this->render('index', compact('homePageModel'));
    }

    // public function actionError(): string
    // {
    //     $this->setMainLayout();
    //     return $this->render('//error');
    // }
}
