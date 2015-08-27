<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\user\widgets\Connect;

/**
 * @var yii\web\View                   $this
 * @var frontend\modules\user\models\LoginForm $model
 * @var frontend\modules\user\Module           $module
 */
$this->context->layout = 'login';
$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

 <div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">           
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

                <?= $form->field($model, 'username', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput()->label('密码' . ($module->enablePasswordRecovery ? ' (' . Html::a('忘记密码', ['/user/recovery/request'], ['tabindex' => '5']) . ')' : '')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

                <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
                <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a('没有收到确认消息?', ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a('没有一个帐户吗?去注册吧!', ['/user/registration/register']) ?>
            </p>
        <?php endif ?>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth']
        ]) ?>
    </div>
</div>