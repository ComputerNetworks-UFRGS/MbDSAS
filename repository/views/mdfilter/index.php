<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Md Filters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="md-filter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Md Filter', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'attribute',
            'value',
            'operator',
            'last_updated',
            // 'id_script',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
