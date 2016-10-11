<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MdFilter */

$this->title = 'Update Md Filter: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Md Filters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'id_script' => $model->id_script]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="md-filter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'scripts' => $scripts,
    ]) ?>

</div>
