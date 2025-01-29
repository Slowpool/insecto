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
        foreach($cardsWithGoods as $card) {
            $temp = $card['category']['name'];
            // TODO it looks like $card is treated as a value type here
            $card['category'] = $temp;
        }
        $searchPageModel = new SearchPageModel($searchModel, $cardsWithGoods);
        return $this->render('index', compact('searchPageModel'));
    }
}
