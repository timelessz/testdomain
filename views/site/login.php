<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '网站状态检测';
$this->params['breadcrumbs'][] = $this->title;

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
        'brandLabel' => '强比科技 网站检测',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="site-login">
            <h1>登陆系统</h1>
            <p></p>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>
            <?= $form->field($model, 'username', ['labelOptions' => ['label' => '用户名']])->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password', ['labelOptions' => ['label' => '密码']])->passwordInput() ?>
            <?= $form->field($model, 'verifyCode', ['labelOptions' => ['label' => '验证码']])->textInput() ?>
            <div class="form-group">
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                    <?php
                    echo Captcha::widget(
                        ['name' => 'captchaimg',
                            'captchaAction' => 'site/captcha',
                            'imageOptions' => ['id' => 'captchaimg', 'title' => '换一个', 'alt' => '换一个', 'style' => 'cursor:pointer;'],
                            'template' => '{image}']);
                    ?>
                </div>
            </div>
            <?= $form->field($model, 'rememberMe', ['labelOptions' => ['label' => '记住我']])->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('登陆', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="col-lg-offset-1" style="color:#999;">
                该系统 为强比科技内部使用 用于检测公司网站或者其他系统运行状态
            </div>
        </div>
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
