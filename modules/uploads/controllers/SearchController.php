<?php

namespace myext\upl\modules\uploads\controllers;

/*use common\base\Controller;
use lib\models\parts\FirstStep;
use lib\models\parts\Parts;
use lib\models\parts\SecondStep;*/
use myext\upl\modules\uploads\models\UploadForm;
use yii\web\HttpException;
use yii;

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
                $path = Yii::$app->params['pathUploads'];
                $model->file->saveAs( $path . $model->file);
                return ['success' => true];
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