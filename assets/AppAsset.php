<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
		'css/angular-carousel.min.css',
		'css/myStyle.css',
    ];
    public $js = [
		'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js',
		'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular-touch.min.js',
		'js/angular-carousel.min.js',
		'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
