<?php

namespace app\controllers;

use app\models\domain\GoodsCategoryRecord;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\ItemCardModel;
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // this action is requested via GET method => needn't csrf
        $this->enableCsrfValidation = false;

        // $get = Yii::$app->request->get();
        // if (isset($get['isAlive'])) {
        //     $get['isAlive'] = 0;
        // }
        
        // if (isset($get['isAvailable'])) {
        //     $get['isAvailable'] = 0;
        // }

        $searchModel = new SearchModel;
        if ($searchModel->load(Yii::$app->request->get(), '') && $searchModel->validate()) {
            $allCategories = GoodsCategoryRecord::getNames();
            // at this moment $searchModel has only the categories, provided in url as a route parameters (they have been read via SearchModel->load() and their values have been set to true)
            foreach ($allCategories as $category) {
                if (!isset($searchModel->categories[$category])) {
                    $searchModel->categories[$category] = false;
                }
            }

            // TODO test it with asArray
            $itemCardModels = Yii::$app->automapper->mapMultiple(UnitOfGoodsRecord::search($searchModel, false), ItemCardModel::class);
        } else {
            $itemCardModels = [];
        }
        $searchPageModel = new SearchPageModel($searchModel, $itemCardModels);
        return $this->render('index', compact('searchPageModel'));
    }
}
