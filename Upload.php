<?php

namespace myext\upl;

use myext\upl\modules\uploads\models\UploadForm;
use yii\web\UploadedFile;
use Yii;

/**
 * This is just an example.
 */
class Upload extends \yii\base\Widget
{
    public function run()
    {
        $model = new UploadForm();

        /*if(Yii::$app->request->post())
        {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $path = Yii::$app->params['pathUploads'];
                $model->file->saveAs( $path . $model->file);
                return true;
            }
        }*/


        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
