<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\forms\BeginMbD;

$this->title = 'Pull and Run Script';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if (\Yii::$app->getSession()->hasFlash('success')): ?>
<div class="alert alert-success">
    <?php echo Html::encode(\Yii::$app->getSession()->getFlash('success')); 
    	
    ?>
</div>
<?php endif; ?>
<?php if (\Yii::$app->getSession()->hasFlash('error')): ?>
<div class="alert alert-danger">
    <?php echo Html::encode(\Yii::$app->getSession()->getFlash('error')); 
    	
    ?>
</div>
<?php endif; ?>


<div class="par-login">
    <h1><?= Html::encode($this->title) ?> (<?= Html::encode($model->mlm) ?>)</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'par-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>	

        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'arguments')->textInput() ?>
        <?= $form->field($model, 'language')->textInput() ?>
        <?= $form->field($model, 'storage')->textInput() ?>
        <?= $form->field($model, 'block')->textInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>