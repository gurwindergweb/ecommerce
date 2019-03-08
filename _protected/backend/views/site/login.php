<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Login');
?>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">G</h1>

        </div>
        <h3>Welcome to IN+</h3>


        <p>Login in. To see it in action.</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'm-t']]); ?>

        <?php //-- use email or username field depending on model scenario --// ?>
        <?php if ($model->scenario === 'lwe'): ?>
            <?= $form->field($model, 'email')->textInput(['class' => 'form-control','placeholder'=>'Email'])->label(false) ?>
        <?php else: ?>
            <?= $form->field($model, 'username')->textInput(['class' => 'form-control','placeholder'=>'Username'])->label(false) ?>
        <?php endif ?>

        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control','placeholder'=>'Password'])->label(false) ?>
        <?= Html::a('Forgot password?', ['resetpass'], ['style' => 'font-size: 85% !important;']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>
