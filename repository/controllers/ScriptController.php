<?php

namespace app\controllers;

use Yii;
use app\models\Script;
use app\models\Language;
use app\models\Code;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * ScriptController implements the CRUD actions for Script model.
 */
class ScriptController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Script models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Script::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Script model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Script model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Script();
        $modelCode = new Code();
        

        if($model->load(Yii::$app->request->post())){

            $model->last_updated = (new \DateTime())->format('Y-m-d H:i:s');
            $file = UploadedFile::getInstance($modelCode, 'path');
            $model->code_identifier = md5_file($file->tempName);

            if ($model->save()) {
                
                $idScript = Yii::$app->db->getLastInsertId();
                if($model->upload($file)){
                    $modelCode->path = $file->name;
                    $modelCode->id_script = $idScript;
                    $modelCode->save();

                    $language = Language::find()->where($model->id_language)->one();
                    $language->last_updated = $model->last_updated;
                    $language->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {

            $languages = Language::find()->all();
            
            return $this->render('create', [
                'model' => $model,
                'modelCode' => $modelCode,
                'languages' => $languages
            ]);
        }
    }

    /**
     * Updates an existing Script model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCode = new Code();

        if($model->load(Yii::$app->request->post())){

            $model->last_updated = (new \DateTime())->format('Y-m-d H:i:s');
            
            if ($model->save()) {
                $file = UploadedFile::getInstance($modelCode, 'path');

                if($file != NULL && $model->upload($file)){
                    $modelCode->path = $file->name;
                    $modelCode->id_script = $id;
                    $modelCode->save();

                    $file = UploadedFile::getInstance($modelCode, 'path');
                    $model->code_identifier = md5_file($file->tempName);
                    $model->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $languages = Language::find()->all();

            return $this->render('create', [
                'model' => $model,
                'modelCode' => $modelCode,
                'languages' => $languages
            ]);
        }
    }

    /**
     * Deletes an existing Script model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $script = $this->findModel($id);
        $code = Code::find()
        ->where(['id_script' => $id])
        ->orderBy(['id' => SORT_DESC])
        ->one();
        //var_dump($code);die();
        $script->deleteFile($code['path']);
        $script->delete();


        return $this->redirect(['index']);
    }

    public function actionList(){
        $sql = "SELECT name FROM script";
        $scripts = Script::findBySql($sql)->all();
        //$scripts = Script::find()->all();

        \Yii::$app->response->format = 'json';
        return $scripts;
    }

    public function actionDownload($name)
    {
        $script = Script::find()
            ->where(['name' => $name])
            ->one();

        if($script){
            $code = Code::find()
                ->where(['id_script' => $script->id])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if($code){
                $path = realpath(\Yii::getAlias("@webroot")."/../script/$code->path");

                if(file_exists($path))
                {
                    return Yii::$app->response->sendFile($path, $code->path, ['inline' => false])->send();
                }
            }

        }
        
        return false;
    }

    /**
     * Finds the Script model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Script the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Script::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
