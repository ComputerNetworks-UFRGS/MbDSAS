<?php

namespace app\controllers;

use app\models\Md;

class MdlistController extends \yii\web\Controller
{
    public function actionGet()
    {
    	\Yii::$app->response->format = 'json';
    	$mds = Md::find()->all();

        return $mds;
    }

    public function actionGetall()
    {
        return $this->render('getall');
    }

}
