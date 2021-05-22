<?php
/**
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
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
