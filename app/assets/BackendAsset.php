<?php
/**
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Ассет для админской части
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath = '@webroot/media/backend';
    public $css = [
        'css/bootstrap.min.css',
        'css/dashboard.css',
        'font-awesome/css/font-awesome.css',
    ];
    public $js = [
    ];
    public $depends = [

    ];
}
