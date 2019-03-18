<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'stock',
            [
                'attribute' => 'category',
                'value' => function($model){
                    $data = Category::find()->where(['id'=>$model->category])->one();
                    return $data['category'];},
            ],
            [
              'attribute' => 'image',
              'value' => function($model){return Url::to('@appRoot',true).'/uploads/product/'.$model->image;},
              'format' => ['image',['width'=>'100','height'=>'100']],

            ],
            //'actual_price',
            //'offer_price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
