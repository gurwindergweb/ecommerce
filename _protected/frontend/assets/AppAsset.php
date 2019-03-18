<?php
/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * -----------------------------------------------------------------------------
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 * -----------------------------------------------------------------------------
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    
    public $css = [
        'css/bootstrap.css',
        'css/flexslider.css',
        'css/style.css',
        'css/popuo-box.css',
        'css/menu.css',
        'css/creditly.css',
        'css/easy-responsive-tabs.css',





    ];
    public $js = [
        'js/jquery-2.2.3.min.js',
        // 'js/minicart.js',
        'js/jquery.flexslider.js',
        'js/myfile.js',
        'js/bootstrap.js',
        'js/creditly.js',
        'js/creditly2.js',
        'js/easing.js',
        'js/easyResponsiveTabs.js',
        'js/imagezoom.js',
        'js/jquery.magnific-popup.js',
        'js/move-top.js',
        'js/scroll.js',
        'js/SmoothScroll.min.js',

    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

