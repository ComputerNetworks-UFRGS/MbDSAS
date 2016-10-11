<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MdFilter */

$this->title = 'Create Md Filter';
$this->params['breadcrumbs'][] = ['label' => 'Md Filters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="md-filter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'scripts' => $scripts,
    ]) ?>

</div>
