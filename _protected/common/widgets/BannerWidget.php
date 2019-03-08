<?php
namespace common\widgets;
use yii;
use yii\base\Widget;
use backend\models\Banner;

class BannerWidget extends  Widget{
    public $enableCsrfValidation = false;

    public function run()
    {
        $model = Banner::find()->where(['status' => 1])->all();
        return $this->render('banner',[
            'model'=>$model,
        ]);
        
    }
}
