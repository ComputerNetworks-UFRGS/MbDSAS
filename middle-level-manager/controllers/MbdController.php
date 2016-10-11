<?php

namespace app\controllers;

use app\components\OSGi;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class MbdController extends \yii\rest\Controller
{
    /**
     * REST Controller behavior
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionGet()
    {
        
    }

    public function actionGetall()
    {
        $osgi = new OSGi();
        $output = $osgi->listbundlestoarray();

        return $output;
    }

    public function actionGetresults()
    {
        return $this->render('getresults');
    }

    public function actionPull()
    {
        if(isset($_POST['url'])){
            $osgi = new OSGi();
            $id = $osgi->installscript($_POST['url']);

            return ['script_id' => $id];
        }
        else
            return ['error' => 'Script url not found'];
    }

    public function actionPullandrun()
    {
        if(isset($_POST['url'])){
            $osgi = new OSGi();
            $id = $osgi->installscript($_POST['url']);

            if(is_numeric($id)){
                $response = $osgi->runscript($id);

                return ['response' => $response];
            }
            else
                return ['error' => 'Script installation error'];
        }
        else
            return ['error' => 'Script url not found'];
    }

    public function actionPush()
    {
        return $this->render('push');
    }

    public function actionRemove()
    {
        if(isset($_POST['id'])){
            $osgi = new OSGi();
            $response = $osgi->removescript($_POST['id']);

            return ['response' => $response];
        }
        else
            return ['error' => 'Bundle id not found'];
    }

    public function actionRun()
    {
        if(isset($_POST['id'])){
            $osgi = new OSGi();
            $response = $osgi->runscript($_POST['id']);

            return ['response' => $response];
        }
        else
            return ['error' => 'Bundle id not found'];

    }

}
