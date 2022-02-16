<?php
/**
 * MainController
 * Главный Контроллер модуля api
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\api\modules\controllers;

use app\models\system\Lang;
use app\modules\api\services\ActionApiService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * MainController for the `api` module
 */
class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => [],
                    ],
                ],
            ],
        ];
    }
}
