<?php

namespace app\controllers;

use app\models\domain\UnitOfGoodsRecord;
use app\models\search\SearchModel;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\search\SearchPageModel;

class SearchController extends ControllerWithCategories
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
            
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel;
        $searchModel->load(Yii::$app->request->get());
        $cardsWithGoods = UnitOfGoodsRecord::search($searchModel);
        $searchPageModel = new SearchPageModel($searchModel, $cardsWithGoods);
        return $this->render('index', compact('searchPageModel'));
    }
}
