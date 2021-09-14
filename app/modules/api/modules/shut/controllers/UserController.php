<?php
/**
 * UserController
 * Контроллер модуля api/shut по Пользователям
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\shut\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;
use app\modules\api\modules\shut\models\UserShutApi;

/**
 * Controller for the `api/shut` module
 */
class UserController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'count-subscribers', 'count-subscriptions'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает пользователя по коду
     * @param string $code
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function actionView()
    {
        return json_encode(UserShutApi::findByCode(Yii::$app->request->get('code')));
    }

    /**
     * Возвращает количество подписчиков
     * @param string $code
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function actionCountSubscribers()
    {
        return json_encode(UserShutApi::getCountSubscribers(Yii::$app->request->get('code')));
    }
}
