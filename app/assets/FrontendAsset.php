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
        'css/main.css',
        'font-awesome/css/font-awesome.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/browser.min.js',
        'js/breakpoints.min.js',
        'js/util.js',
        'js/main.js',
    ];
    public $depends = [

    ];
}
