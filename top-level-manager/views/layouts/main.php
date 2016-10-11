<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'MbDSAS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'MbD Actions', 'items' => [
                    ['label' => 'Begin MbD', 'url'=> ['/mbd/beginmbd']],
                    ['label' => 'Pull Script', 'url'=> ['/mbd/pullscript']],
                    ['label' => 'Pull and Run Script', 'url'=> ['/mbd/pullandrunscript']],
                    ['label' => 'Remove Script', 'url'=> ['/mbd/removescript']],
                    ['label' => 'Replace Script', 'url'=> ['/mbd/replacescript']],
                    ['label' => 'Run Script', 'url'=> ['/mbd/runscript']]
                ]
            ],
            ['label' => 'MDL Actions', 'items' => [
                    ['label' => 'Get MDL', 'url'=> ['/mdlist/get']],
                    ['label' => 'Update MDL', 'url'=> ['/mdlist/update']]
                ]
            ],
            ['label' => 'MLM', 'url' => ['/mlm']],
            ['label' => 'Repositories', 'url' => ['/repository']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
