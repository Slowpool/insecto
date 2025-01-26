<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;

class ControllerWithCategories extends Controller {
    public function beforeAction($action): bool {
        if(parent::beforeAction($action)) {
            $this->layout = 'layout_with_categories';
            $this->view->params['categoriesModel'] = self::getCategories();
            return true;
        }
        return false;
    }

    /**
     * You can call it inside controller's method to use default layout.
     * @return void
     */
    protected function setDefaultLayout(): void {
        $this->layout = 'main';
        unset($this->view->params['categoriesModel']);
    }

    private static function getCategories(): array {
        // TODO now a latch is here,
        return ['Dragonflies' => Url::to('goods/dragonflies'), 'Spiders' => Url::to('goods/spiders')];
    }
}