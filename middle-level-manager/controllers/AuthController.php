<?php

namespace app\controllers;

class AuthController extends \yii\web\Controller
{
    public function actionBeginmbd()
    {
        return $this->render('beginmbd');
    }

    public function actionEndmbd()
    {
        return $this->render('endmbd');
    }

}
