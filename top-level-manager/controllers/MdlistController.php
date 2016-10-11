<?php

namespace app\controllers;

class MdlistController extends \yii\web\Controller
{
    public function actionGet()
    {
        return $this->render('get');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

}
