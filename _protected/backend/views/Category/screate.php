<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'Create Sub Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="category-form">
        <?= Html::a('Back', ['view','id' => $s_id], ['class' => 'btn btn-warning']) ?>
        <?php $form = ActiveForm::begin(['action'=>'categorysave?id='.$s_id]); ?>

        <?= $form->field($model, 'sub_category_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model,'category_id')->hiddenInput(['value'=>$s_id])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>