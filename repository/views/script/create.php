<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Script */

$this->title = 'Create Script';
$this->params['breadcrumbs'][] = ['label' => 'Scripts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="script-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelCode' => $modelCode,
        'languages' => $languages
    ]) ?>

</div>
