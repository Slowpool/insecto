<?php

namespace app\models\search;

use app\models\domain\GoodsCategoryRecord;
use yii\base\Model;

class SearchModel extends Model {
    public ?string $searchText = null;
    public ?array $categories = null;
    public ?bool $isAlive = null;
    public ?bool $isAvailable = null;
    public ?int $minPrice = null;
    public ?int $maxPrice = null;
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

    /**
     * This method parses `categories` as array rather than string.
     * explanation: `localhost:8000/insects/dioptra/ortopetrpha/stick insects` => ['dioptra', 'ortopetrpha', 'stick insects']
     * @param mixed $data
     * @param mixed $formName
     * @return bool
     */
    public function load($data, $formName = null): bool {
        $this->categories = explode('/', $data['categories']);
        unset($data['categories']);
        return parent::load($data, $formName);
    }
}