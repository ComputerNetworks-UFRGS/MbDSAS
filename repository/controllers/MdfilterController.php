<?php

namespace app\controllers;

use Yii;
use app\models\MdFilter;
use app\models\Script;
use app\models\Language;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MdfilterController implements the CRUD actions for MdFilter model.
 */
class MdfilterController extends Controller
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
     * Lists all MdFilter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MdFilter::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MdFilter model.
     * @param integer $id
     * @param integer $id_script
     * @return mixed
     */
    public function actionView($id, $id_script)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $id_script),
        ]);
    }

    /**
     * Creates a new MdFilter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MdFilter();

        if($model->load(Yii::$app->request->post())){

            $model->last_updated = (new \DateTime())->format('Y-m-d H:i:s');
            $model->identifier = md5($model->attribute.$model->value.$model->operator.$model->last_updated);

            if ($model->save()) {

                $script = Script::find()->where(['id' => $model->id_script])->one();
                $script->last_updated = $model->last_updated;
                $script->save();

                $language = Language::find()->where(['id' => $script->id_language])->one();
                $language->last_updated = $model->last_updated;
                $language->save();

                return $this->redirect(['view', 'id' => $model->id, 'id_script' => $model->id_script]);
            }
        } else {
            $scripts = Script::find()->all();

            return $this->render('create', [
                'model' => $model,
                'scripts' => $scripts,
            ]);
        }
    }

    /**
     * Updates an existing MdFilter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_script
     * @return mixed
     */
    public function actionUpdate($id, $id_script)
    {
        $model = $this->findModel($id, $id_script);

        if($model->load(Yii::$app->request->post())){

            $model->last_updated = (new \DateTime())->format('Y-m-d H:i:s');

            if ($model->save()) {

                $script = Script::find()->where(['id' => $model->id_script])->one();
                $script->last_updated = $model->last_updated;
                $script->save();

                $language = Language::find()->where(['id' => $script->id_language])->one();
                $language->last_updated = $model->last_updated;
                $language->save();
                
                return $this->redirect(['view', 'id' => $model->id, 'id_script' => $model->id_script]);
            }
        } else {
            $scripts = Script::find()->all();

            return $this->render('update', [
                'model' => $model,
                'scripts' => $scripts,
            ]);
        }
    }

    /**
     * Deletes an existing MdFilter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_script
     * @return mixed
     */
    public function actionDelete($id, $id_script)
    {
        $this->findModel($id, $id_script)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MdFilter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_script
     * @return MdFilter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_script)
    {
        if (($model = MdFilter::findOne(['id' => $id, 'id_script' => $id_script])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
