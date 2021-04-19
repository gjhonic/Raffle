<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Backend application asset bundle.
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath = '@app/media/backend';
    public $css = [
        'css/bootstrap.min.css',
        'css/dashboard.css',
    ];
    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/dashboard.js',
    ];
    public $depends = [

    ];
}
