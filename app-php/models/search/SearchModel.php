<?php

namespace app\models\search;

use app\models\domain\GoodsCategoryRecord;
use yii\base\Model;

class SearchModel extends Model {
    public string $searchText;
    public array $categories;
    public bool $isAlive;
    public bool $isAvailable;
    public int $minPrice;
    public int $maxPrice;
    public function rules() {
        return [
            [['minPrice'], 'compare', 'compareAttribute' => 'maxPrice', 'operator' => '<=', 'message' => 'Minimal price must be lower than or equal to maximum price.'],
            [['categories'], 'validateCategories', 'Some category(ies) you specified does not exist'],
            // TODO validate that categories aren't repeated 
        ];
    }

    public function validateCategories($categories, $params) {
        foreach($categories as $category) {
            if (!GoodsCategoryRecord::exists($category)) {
                return false;
            }
        }
        return true;
    }

    public function load($data, $formName = null): bool {
        // `localhost:8000/insects/dioptra/ortopetrpha/stick insects` => ['dioptra', 'ortopetrpha', 'stick']
        $this->categories = explode('/', $data['categories']);
        unset($data['categories']);
        return parent::load($data, $formName);
    }
}