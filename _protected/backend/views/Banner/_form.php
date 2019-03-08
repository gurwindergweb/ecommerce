<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">
    <p>
        <?= Html::a('Back', ['index'],  ['class' => 'btn btn-primary']) ?>
    </p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offer')->textInput(['maxlength' => true]) ?>
    <?php
    if(!isset($model->status) || ($model->status==1)){
        $data = 1;
    }
    else
    {
        $data= 0;
    }
    ?>
    <?= $form->field($model, 'status')->hiddenInput(['value'=>$data])->label(false) ?>

    <?= $form->field($model, 'image')->fileInput() ?>
        <?php if(!empty($model->image)){?>
            <img src="<?= Url::to('@appRoot',true).'/uploads/banner/'.$model->image; ?>" height="100" width="100">
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
