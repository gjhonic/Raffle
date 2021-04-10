<?php
/**
 * MainController
 * Главные Контроллер модуля admin
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\helpers\Url;

/**
 * Default controller for the `admin` module
 */
class MainController extends Controller
{
    public $layout = "main";
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
