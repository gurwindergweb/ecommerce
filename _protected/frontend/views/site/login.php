<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h5 class="modal-title text-center"><?= Html::encode($this->title) ?></h5>

    <div class="col-lg-5 well bs-component">
        <div class="modal-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group">
        <?php //-- use email or username field depending on model scenario --// ?>
        <?php if ($model->scenario === 'lwe'): ?>
            <?= $form->field($model, 'email') ?>        
        <?php else: ?>
            <?= $form->field($model, 'username',[
                'labelOptions'=>['class'=>'col-form-label'],
            ]) ?>
        <?php endif ?>
                </div>
            <div class="form-group">
        <?= $form->field($model, 'password',[
            'labelOptions'=>['class'=>'col-form-label'],
        ])->passwordInput() ?>
            </div>
        <div style="color:#999;margin:1em 0">
            <?= Yii::t('app', 'If you forgot your password you can') ?>
            <?= Html::a(Yii::t('app', 'reset it'), ['site/request-password-reset']) ?>.
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
            <p class="text-center dont-do mt-3">Don't have an account?
                <a href="<?= Url::Base() ?>/site/signup" data-toggle="modal" data-target="#exampleModal2">
                    Register Now</a>
            </p>
        <?php ActiveForm::end(); ?>

    </div>
  
</div>
</div>