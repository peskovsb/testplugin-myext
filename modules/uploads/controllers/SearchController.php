<?php

namespace myext\upl\modules\uploads\controllers;

/*use common\base\Controller;
use lib\models\parts\FirstStep;
use lib\models\parts\Parts;
use lib\models\parts\SecondStep;*/
use myext\upl\modules\uploads\models\UploadForm;
use yii\web\HttpException;
use yii;
use yii\imagine\Image;

/**
 * Контроллер отвечает за поиск через коробку DocParts
 */
class SearchController extends yii\base\Controller
{
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['customer'],
                    ],
                ],
            ],
        ];
    }*/

    public function actionManuf()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new UploadForm();

        if(Yii::$app->request->post())
        {

            $model->file = yii\web\UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {

                $path_l = Yii::$app->params['pathUploads'] . '/l/';
                $model->file->saveAs( $path_l . $model->file);

                $path_s = Yii::$app->params['pathUploads'] . '/s/';

                Image::thumbnail($path_l . $model->file->name, 500, 500)
                    ->save($path_s . $model->file->name, ['quality' => 100]);

                return [
                    'success' => true,
                    'src' => $model->file->name
                ];
            }else{
                return ['errors' => $model->getErrors()['file']];
            }
        }
    }

    public function actionGetProducts()
    {
        $model = new SecondStep();
        $model->setAttributes(Yii::$app->request->get());

        if(Yii::$app->request->isAjax){
            return $model->getSecondStep();
        }
        throw new HttpException(403 ,'Нет прав');
    }

    public function actionGetSuppliers()
    {
        $model = new Parts();
        $model->setAttributes(Yii::$app->request->get());

        if(Yii::$app->request->isAjax) {
            return $model->getListSuppliers();
        }
        throw new HttpException(403 ,'Нет прав');
    }
}