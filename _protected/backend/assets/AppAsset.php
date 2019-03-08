<?php
/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 *
 * Customized by Nenad Živković
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/css/font-awesome.css',
        'css/plugins/toastr/toastr.min.css',
        'js/plugins/gritter/jquery.gritter.css',
        'css/animate.css',
        'css/style.css',

    ];
    public $js = [
        'js/loadingoverlay.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.spline.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.pie.js',
        'js/plugins/peity/jquery.peity.min.js',
        'js/demo/peity-demo.js',
        //'js/inspinia.js',
        //'js/jquery-2.1.1.js',
        //'js/bootstrap.min.js',
        'js/plugins/pace/pace.min.js',
        'js/plugins/jquery-ui/jquery-ui.min.js',
        'js/plugins/gritter/jquery.gritter.min.js',
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/demo/sparkline-demo.js',
        'js/plugins/chartJs/Chart.min.js',
        'js/plugins/toastr/toastr.min.js',
        'js/custom.js',
        'js/myfile.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
