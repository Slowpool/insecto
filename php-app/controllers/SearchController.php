<?php

namespace app\controllers;

use app\models\domain\GoodsCategoryRecord;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\SearchItemCardModel;
use app\models\search\SearchModel;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\search\SearchPageModel;

class SearchController extends BaseControllerWithCategories
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

        $searchModel = new SearchModel;
        if ($searchModel->load(Yii::$app->request->get(), '') && $searchModel->validate()) {
            $goodsRecords = UnitOfGoodsRecord::searchEverywhere($searchModel, false);
            $itemCardModels = Yii::$app->automapper->mapMultiple($goodsRecords, SearchItemCardModel::class);
            // TODO it can be done via previous mapMultiple() (in other words, reconfigure automapper)
            foreach($goodsRecords as $key => $goodsRecord) {
                Yii::$app->automapper->mapToObject($goodsRecord->category, $itemCardModels[$key]);
            }
        } else {
            $itemCardModels = null;
        }
        $searchPageModel = new SearchPageModel($searchModel, $itemCardModels);
        return $this->render('index', compact('searchPageModel'));
    }
}
