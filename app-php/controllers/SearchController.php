<?php

namespace app\controllers;

use app\models\domain\GoodsCategoryRecord;
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
        if ($searchModel->load(Yii::$app->request->get()) && $searchModel->validate()) {
            $allCategories = GoodsCategoryRecord::getNames();
            // at this moment $searchModel has only the categories, provided in url as a route parameters (they have been read via SearchModel->load() and their values have been set to true)
            foreach ($allCategories as $category) {
                if (!isset($searchModel->categories[$category])) {
                    $searchModel->categories[$category] = false;
                }
            }

            $cardsWithGoods = UnitOfGoodsRecord::search($searchModel);
        } else {
            $cardsWithGoods = [];
        }
        $searchPageModel = new SearchPageModel($searchModel, $cardsWithGoods);
        return $this->render('index', compact('searchPageModel'));
    }
}
