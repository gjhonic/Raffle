<?php
/**
 * UserController
 * Контроллер предназначеный для работы с пользователями по Ajax
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\controllers\ajax;

use app\services\user\StatusService;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\base\User;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['check-banned'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ]
                ],
            ],
        ];
    }

    /**
     * Метод проверяте статус пользователя
     * @param string $user_code
     * @return Response
     */
    public function actionCheckBanned(string $user_code): Response
    {
        /* @var $user User */
        $user = User::findByCode($user_code);
        return $this->asJson(StatusService::checkStatusBanUser($user));
    }
}
