<?php

namespace app\models\home;

/**
 * Summary of HomePageModel
 * @property PopularItemCardModel[] $itemCardModels
 */
class HomePageModel {
    public array $itemCardModels;
    public function __construct(array $itemCardModels) {
        $this->itemCardModels = $itemCardModels;

    }
}