<?php
/**
 * MainController
 * Главные Контроллер модуля admin
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;

/**
 * Default controller for the `admin` module
 */
class MainController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }


    /**
     * Displays homepage module admin.
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
