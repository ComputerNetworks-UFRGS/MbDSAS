<?php

namespace app\controllers;

use app\models\Mlm;

class MlmController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $mlms = Mlm::findBySql("SELECT * FROM mlm")->all();

        return $this->render('index',[
                'mlms' => $mlms
            ]);
    }

    public function actionCreate()
    {
    	$model = new Mlm();

        if(isset($_POST['Mlm'])){
            $attributes = $_POST['Mlm'];
            $model->setAttributes($attributes);

            if($model->save())
                \Yii::$app->getSession()->setFlash('success', 'Mlm created');
            else
                \Yii::$app->getSession()->setFlash('error', 'Mlm could not be created');

        }

    	return $this->render('create',[
    		'model' => $model
    		]);
    }

    public function actionGet(){

        $mlms = [['label' => 'Teste', 'url' => '192.168.1.2']];
        \Yii::$app->response->format = 'json';
        
        return $mlms;
    }
}
