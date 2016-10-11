<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scripts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="script-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Script', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'owner',
            'name',
            'source',
            //'admin_status',
            // 'oper_status',
            // 'storage_type',
            // 'row_status',
            // 'error',
             'last_updated',
            // 'descr:ntext',
            // 'id_language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
