<?php

namespace app\models\search;

use yii\base\Model;

class SearchModel extends Model
{
    public ?string $q = null;
    public function rules() {
        return [
            [['q'], 'required'],
            [['q'], 'string', 'min' => 1, 'max' => DB_GOODS_NAME_MAX_LEN]
        ];
    }

    public function formName() {
        return '';
    }

    public function attributeLabels() {
        return [
            'q' => 'Search text',
        ];
    }

}