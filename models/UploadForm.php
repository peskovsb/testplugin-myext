<?php

namespace myext\upl\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{

    public $file;

    public function rules()
    {
        return [
            // username and password are both required

            [['file'], 'file', 'extensions' => 'png, jpg',
                'skipOnEmpty' => false]];
    }

    public function uploadStart()
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->validate()) {
            $path = \Yii::$app->params['pathUploads'];
            $this->file->saveAs( $path . $this->file);

            return '';
        }else{
            return 'ошибка';
        }
    }

}