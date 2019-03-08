<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'offer:ntext',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data->status==0) {
                        return Html::a(Yii::t('app', 'Active'), null, [
                            'class' => 'btn btn-success status',
                            'data-id' =>  $data->id,
                            'data-status' =>  $data->status,
                            'href' => 'javascript:void(0);',
                        ]);
                    } else {
                        return Html::a(Yii::t('app', 'Inactive'), null, [
                            'class' => 'btn btn-danger status',
                            'data-id' =>  $data->id,
                            'data-status' =>  $data->status,
                            'href' => 'javascript:void(0);',
                        ]);
                    }
                },
                'contentOptions' => ['style' => 'width:160px;text-align:center'],
                'format' => 'raw',
                'filter'=>array("1"=>"Active","0"=>"Inactive"),
            ],
            array(
                'attribute'=>'image',
                'value'=>function ($model) { return Url::to('@appRoot',true).'/uploads/banner/'.$model->image;},
                'format' => ['image',['width'=>'100','height'=>'100']],
             ),

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
