<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use app\models\domain\GoodsCategoryRecord;

abstract class BaseControllerWithCategories extends Controller {
    public function beforeAction($action): bool {
        if(parent::beforeAction($action)) {
            $this->layout = 'layout_with_categories';
            $this->view->params['categoriesModel'] = self::getGoodsCategories();
            return true;
        }
        return false;
    }

    /**
     * You can call it inside controller's method to use default layout.
     * @return void
     */
    protected function setMainLayout(): void {
        $this->layout = 'main';
        unset($this->view->params['categoriesModel']);
    }

    private static function getGoodsCategories(): array {
        return GoodsCategoryRecord::getNames();
    }
}