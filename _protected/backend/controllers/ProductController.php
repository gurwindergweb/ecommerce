<?php

namespace backend\controllers;

use backend\models\Gallary;
use backend\models\Scategory;
use backend\models\Category;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\traits\AjaxStatusTrait;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $enableCsrfValidation = false;
    use AjaxStatusTrait;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionLists($id)
    {

        /*$categ = Category::find()
            ->where(['category' => $id])
            ->one();


        $cat = $categ->id;*/

        $countcat = Scategory::find()->where(['category_id'=>$id])->count();

        $selectcat = Scategory::find()->where(['category_id'=>$id])->all();

        if($countcat > 0 )
        {
            foreach($selectcat as $city ){
                echo "<option value='".$city->id."'>".$city->sub_category_name."</option>";
            }
        }
        else{
            echo "<option> - </option>";
        }

    }

    public function actionQuickStatus(){
        $request = Yii::$app->request;
        if($request->isAjax) {
            $id = Yii::$app->request->post('id');
            $model = Product::findOne($id);
            return  $this->changeStatus($model);

        }
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model1 = Gallary::find()->where(['product_id'=>$id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model1'=>$model1,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model1 = new Gallary();

        if ($model->load(Yii::$app->request->post())) {
            global $data_val;
            $model->image = UploadedFile::getInstance($model,'image');

            if($model->validate())
            {

                $model->upload();
                $model->save();
                $data_val = $model->id;
            }

        }
        if($model1->load(Yii::$app->request->post()))
        {

            $model1->images = UploadedFile::getInstances($model1,'images');
            if($model1->validate()) {
                foreach ($model1->images as $file) {
                    $model2 = new Gallary();
                    $file->saveAs('../uploads/product/' . $file->baseName . '.' . $file->extension);
                    $model2->images = $file->name;
                    $model2->product_id = $data_val;
                    $model2->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }


        return $this->render('create', [
            'model' => $model,
            'model1' => $model1,
        ]);
    }

   /* public function actionCreate1($id,$id1)
    {
        $model1 = new Gallary();
        if ($model1->load(Yii::$app->request->post())) {
            $model1->images = UploadedFile::getInstance($model1,'images');
                $model1->images->saveAs('../uploads/product/'. $model1->images->baseName . '.' . $model1->images->extension);
                $model1->images = $model1->images->name;
                $model1->save();
                return $this->redirect(['update', 'id' => $id]);
        }
        return $this->render('create1', [
            'model1' => $model1,
            'id' =>$id,
            'id1' =>$id1,
        ]);

    } */

    public function actionUpdate1($id,$id1)
    {
        $model1 = Gallary::find()->where(['id'=>$id1])->one();
        $old_img = $model1->images;
        if($model1->load(Yii::$app->request->post()))
        {

            if(UploadedFile::getInstance($model1,'images'))
            {
                $model1->images = UploadedFile::getInstance($model1,'images');
                $model1->images->saveAs('../uploads/product/'. $model1->images->baseName . '.' . $model1->images->extension);
                $model1->images = $model1->images->name;

            }
            else
            {
                $model1->images = $old_img;
            }
            // print_r($data->name);die('test');
            if($model1->validate())
            {
                $model1->save();
                return $this->redirect(['update', 'id' => $id]);
            }
        }
        return $this->render('update1', [
            'model1' => $model1,
            'id' =>$id,
            'id1' =>$model1->id,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model1 = new Gallary();
        $old_pimage = $model->image ;

        if ($model->load(Yii::$app->request->post())) {
            // print_r($model1);die('test');
            if(UploadedFile::getInstance($model,'image'))
            {
                $model->image = UploadedFile::getInstance($model,'image');
                $model->upload();
            }
            else
            {
                $model->image = $old_pimage;
            }
            if($model->validate())
            {
                 $model->save();
                // return $this->redirect(['view', 'id' => $model->id]);
            }


        }

        if($model1->load(Yii::$app->request->post()))
        {
            $model1->images = UploadedFile::getInstances($model1,'images');

            if($model1->validate()) {
                foreach ($model1->images as $file) {
                    $model2 = new Gallary();
                    $file->saveAs('../uploads/product/' . $file->baseName . '.' . $file->extension);
                    $model2->images = $file->name;
                    $model2->product_id = $id;
                    $model2->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Gallary::deleteAll(['product_id'=>$id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionDelete1($id,$id1)
    {
        $customer = Gallary::findOne($id1);
        $customer->delete();

        /*return $this->redirect('update',[
            'id'=>$id,
        ]);*/
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
