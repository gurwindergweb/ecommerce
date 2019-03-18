<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\models\Category;
use backend\models\Scategory;
use yii\grid\GridView;
use yii\data\SqlDataProvider;
use backend\models\Gallary;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'],  ['class' => 'btn btn-success']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'status',
            'features',
            'stock',
            'description',
            [
                'attribute' => 'category',
                'value' => function($model){
                    $data = Category::find()->where(['id'=>$model->category])->one();
                    return $data['category'];},
            ],
            'actual_price',
            'offer_price',
            [
                'attribute' => 'sub_category',
                'value' => function($model){
                    $data = Scategory::find()->where(['id'=>$model->sub_category])->one();
                    return $data['sub_category_name'];},
            ],
            [
                'attribute'=>'image',
                'value'=>Url::to('@appRoot',true).'/uploads/product/'.$model->image,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            /*[
                'attribute'=>'gallary_image',
                'value'=>function($model){ $model->gallary_image = explode(" ",$model->gallary_image); foreach($model->gallary_image as $file){ return Url::to('@appRoot',true).'/uploads/product/'.$file; } },
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],*/
        ],
    ]) ?>
  <label class="control-label" for="gallary-images">Gallary Images</label><br>
          <?php  $model1 = Gallary::find()->where(['product_id'=>$model->id])->all();
            if(!empty($model1)) {
            foreach($model1 as $file)
            {?>
                <img src="<?= Url::to('@appRoot',true).'/uploads/product/'.$file->images?>" width="100" height="100">
            <?php } } ?>

</div>
