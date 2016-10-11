<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Extensions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extension-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Extension', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'extension',
            'version',
            'vendor',
            'revision',
            // 'descr:ntext',
            // 'id_language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
