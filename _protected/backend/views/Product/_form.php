<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Category;
use yii\helpers\ArrayHelper;
use backend\models\Scategory;
use backend\models\Gallary;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<?= Html::a('Back', ['index'],  ['class' => 'btn btn-primary']) ?>
<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'stock')->textInput(['maxlength'=>true]) ?>

    <?= $form->field($model, 'features')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
            'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
        ]
    ]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
            'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
        ]
    ]) ?>

    <?php
    if(!isset($model->status)||($model->status==1))
    {
        $data=1;
    }
    else
    {
        $data = 0;
    }
    ?>

    <?= $form->field($model, 'status')->hiddenInput(['value'=>$data])->label(false) ?>

    <?php

    $category=Category::find()->all();

    $listData=ArrayHelper::map($category,'id','category');

    echo $form->field($model, 'category')->dropDownList(
        $listData,
        ['prompt'=>'Select...',
        'onchange'=>'
                    $.get( "'.Url::toRoute('/product/lists').'", { id: $(this).val() } )
                        .done(function( data ) {
                            $( "#'.Html::getInputId($model, 'sub_category').'" ).html( data );
                        }
                    );'
        ]
    );
    ?>
    <?php
    if(!empty($model->category))
    {
        $data_cat = Scategory::find()->where(['category_id'=>$model->category])->all();
    }
    else
    {
        $data_cat = [];
    }
    ?>
    <?= $form->field($model,'sub_category')->dropDownList(
        ArrayHelper::map($data_cat , 'id', 'sub_category_name'),
        [
            'prompt'=>'Select one',

        ]);
    ?>




    <?= $form->field($model, 'actual_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'image')->fileInput() ?>
    <?php if(!empty($model->image)) { ?>
    <img src="<?= Url::to('@appRoot',true).'/uploads/product/'.$model->image?>" width="100" height="100">
    <?php } if($model->isNewRecord) {?>
    <?= $form->field($model1, 'images[]')->fileInput(['multiple' => 'multiple', 'accept' => 'image/*']) ?>
    <?php }
    else {
        global $data_image;
        $data_image = $model->id;
        $data_model = Gallary::find()->where(['product_id'=>$data_image])->one();
        ?>
       <?= $form->field($model1, 'images[]')->fileInput(['multiple' => 'multiple', 'accept' => 'image/*']) ?>
        <?php
        $count = Yii::$app->db->createCommand('
    SELECT COUNT(*) FROM gallary WHERE product_id=:status
', [':status' => $model->id])->queryScalar();

        $provider = new SqlDataProvider([
            'sql' => 'SELECT * FROM gallary WHERE product_id=:status',
            'params' => [':status' => $model->id],
            'totalCount' => $count,
        ]);

// returns an array of data rows
        $models = $provider->getModels();

        ?>
        <?= GridView::widget([
            'dataProvider' => $provider,

            'columns' => [
                [
                    'attribute' => 'images',
                    'value' => function($model1)use($data_image){
                        $model2 = Gallary::findOne([
                            'product_id' => $data_image,
                            'id' => $model1['id'],
                        ]);
                        return Url::to('@appRoot',true).'/uploads/product/'.$model2['images'];},
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
                //'actual_price',
                //'offer_price',

                [

                    'class' => 'yii\grid\ActionColumn',

                    'template' => '{update} {delete}',

                    'buttons' => [

                        'update' => function ($url, $model1, $key) use ($data_image) {

                            return  Html::a('Update', ['update1', 'id' =>$data_image,'id1'=>$model1['id']], ['class' => 'bg-blue label']);

                        },

                        'delete' => function ($url, $model1, $key) use ($data_image) {

                            return  Html::a('Delete', ['delete1','id' =>$data_image,'id1'=>$model1['id']], ['class' => 'bg-red label','data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],]);

                        }

                    ]

                ],
            ],
        ]); ?>
   <?php }?>
         <?php   /*
                ?>
               <br> <label class="control-label" for="gallary-images">Gallary Images</label><br>
            <?php }

            $model1 = Gallary::find()->where(['product_id'=>$model->id])->all();
            if(!empty($model1)) {
            foreach($model1 as $file)
            {?>
                <img src="<?= Url::to('@appRoot',true).'/uploads/product/'.$file->images?>" width="100" height="100">
            <?php } }*/?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
