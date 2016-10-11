<?php

namespace app\controllers;

use app\models\Repository;

class RepositoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$repositories = Repository::findBySql("SELECT * FROM repository")->all();

        return $this->render('index',[
        		'repositories' => $repositories
        	]);
    }

    public function actionCreate()
    {
    	$model = new Repository();

    	if(isset($_POST['Repository'])){
    		$attributes = $_POST['Repository'];
    		$model->setAttributes($attributes);

    		if($model->save())
    			\Yii::$app->getSession()->setFlash('success', 'Repository created');
    		else
    			\Yii::$app->getSession()->setFlash('error', 'Repository could not be created');

    	}

    	return $this->render('create',[
    		'model' => $model
    		]);
    }

}
