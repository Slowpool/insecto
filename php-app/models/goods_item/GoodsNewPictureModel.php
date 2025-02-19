<?php

namespace app\models\goods_item;

use yii\base\Model;
use yii\web\UploadedFile;

class GoodsNewPictureModel extends Model {
    public $unitOfGoodsId;
    public $newPicture;
    public function rules() {
        return [
            [['unitOfGoodsId'], 'required'],
            [['unitOfGoodsId'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
            [['newPicture'], 'required'],
            [['newPicture'], 'file', 'extensions' => 'jpg, png'],
        ];
    }

    public function formName() {
        return '';
    }

    public function beforeValidate() {
        if (parent::beforeValidate())
        {
            $this->newPicture = UploadedFile::getInstance($this, 'newPicture');
            return true;
        }
        return false;
    }
}