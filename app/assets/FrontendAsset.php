<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Ассет для фронтендской части
 */
class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@app/media/frontend';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/lightbox.css',
        'css/main.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquery.js',
        'js/bootstrap.min.js',
        'js/lightbox.min.js',
        'js/wow.min.js',
        'js/main.js',
    ];
    public $depends = [

    ];
}
