<?php

use yii\helpers\Html;
use backend\models\Gallary;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Update Product: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $model1 = new Gallary(); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'model1'=> $model1,
    ]) ?>

</div>
