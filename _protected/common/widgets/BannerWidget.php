<?php
namespace common\widgets;
use yii;
use yii\base\Widget;
use backend\models\Banner;

class BannerWidget extends  Widget{
    public $enableCsrfValidation = false;

    public function run()
    {
        $model = Banner::find()->all();
        return $this->render('banner',[
            'model'=>$model,
        ]);
        
    }
}
