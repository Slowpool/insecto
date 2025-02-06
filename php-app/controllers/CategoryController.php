<?php

namespace app\controllers;

use app\models\category\CategorizedItemCardModel;
use Yii;
use app\models\category\CommonCategorizedFilter;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\domain\GoodsCategoryRecord;
use app\models\category\CategorizedPageModel;
use app\models\domain\UnitOfGoodsRecord;
use app\models\search\SearchItemCardModel;
use yii\web\NotFoundHttpException;

class CategoryController extends BaseControllerWithCategories
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

    public function actionIndex($categorySlug)
    {
        $category = GoodsCategoryRecord::findBySlug($categorySlug);
        if ($category == null) {
            throw new NotFoundHttpException('Such a category does not exist');
        }

        $categorizedFilter = new CommonCategorizedFilter;
        if ($categorizedFilter->load(Yii::$app->request->get(), '') && $categorizedFilter->validate()) {
            $goodsRecords = UnitOfGoodsRecord::searchWithFilter($category->name, $categorizedFilter, false);
            $itemCardModels = Yii::$app->automapper->mapMultiple($goodsRecords, CategorizedItemCardModel::class);
        } else {
            $itemCardModels = [];
        }

        $categorizedPageModel = new CategorizedPageModel($category->name, $category->slug, $categorizedFilter, $itemCardModels);
        return $this->render('index', compact('categorizedPageModel'));
    }

}