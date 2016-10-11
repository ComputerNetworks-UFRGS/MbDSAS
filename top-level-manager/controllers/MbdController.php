<?php

namespace app\controllers;

use app\models\forms\BeginMbD;
use app\models\Repository;
use app\models\Mlm;
use app\models\forms\PullandRunScript;
use app\components\Mycurl;

class MbdController extends \yii\web\Controller
{
    public function actionBeginmbd()
    {
        $model = new BeginMbD();

        if(!empty($_POST)){
            $data = $_POST['BeginMbD'];
            $json = json_encode($data);

            $curl = new Mycurl('http://'.$model->getMlm().'/Remoa/control/OSGiBeginMbD.php');
            $curl->setPost(['data' => $json]);
            $curl->createCurl();
            $content = $curl->__tostring();   

            $return_json = json_decode($content);

            if(isset($return_json->sessionID)){
                \Yii::$app->session->open();
                \Yii::$app->session['mbdsas-sessionid'] = $return_json->sessionID;

                \Yii::$app->getSession()->setFlash('success', 'MLM has began. SESSION ID: '.$return_json->sessionID);
            }
            else{
                \Yii::$app->getSession()->setFlash('error', 'MLM has not began');
            }
            
        }

        
        return $this->render('beginmbd',[
                'model' => $model
            ]);
    }

    public function actionPullandrunscript()
    {
        $model = new PullandRunScript();
        if(!empty($_POST)){
            if(isset(\Yii::$app->session['mbdsas-sessionid'])){
                $data = $_POST['PullandRunScript'];
                $data['sessionID'] = \Yii::$app->session['mbdsas-sessionid'];
                $json = json_encode($data);

                $curl = new Mycurl('http://'.$model->getMlm().'/Remoa/control/SmOSGi/ScriptDownloadAndRun/ScriptDownloadAndRun.php');
                $curl->setPost(['data' => $json]);
                $curl->createCurl();
                $content = $curl->__tostring();   

                $return_json = json_decode($content);
                if(isset($return_json->result)){
                    \Yii::$app->getSession()->setFlash('success', $return_json->result);
                }
                else{
                    \Yii::$app->getSession()->setFlash('error', "Error: ".$return_json->Error);
                }
            }
            else
                \Yii::$app->getSession()->setFlash('error', "You need to BeginMbD first");

            

        }
        return $this->render('pullandrunscript', [
                'model' => $model
        ]);
    }

    public function actionPullscript()
    {
        $repositories = Repository::findBySql("SELECT * FROM repository")->all();

        $scripts = [];
        foreach($repositories as $repository){
            $curl = new Mycurl($repository->url);
            $curl->createCurl();
            $content = $curl->__tostring();

            $scripts = array_merge($scripts, json_decode($content));
        }

        $mlms = Mlm::findBySql("SELECT * FROM mlm")->all();

        
        return $this->render('pullscript',[
                'scripts' => $scripts,
                'mlms' => $mlms
            ]);
    }

    public function actionRemovescript()
    {
        return $this->render('removescript');
    }

    public function actionReplacescript()
    {
        return $this->render('replacescript');
    }

    public function actionRunscript()
    {
        return $this->render('runscript');
    }

}
