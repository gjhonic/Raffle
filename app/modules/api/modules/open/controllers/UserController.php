<?php
/**
 * UserController
 * Контроллер модуля api/open по Пользователям
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\open\controllers;

use app\modules\api\models\ErrorApi;
use Yii;
use app\models\base\User;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\modules\api\modules\open\models\UserOpenApi;
use yii\web\Response;

/**
 * Controller for the `api/open` module
 */
class UserController extends BaseController
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
                        'actions' => ['get', 'raffles', 'countsubscribers', 'countsubscriptions', 'subscribe'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает пользователя по коду
     * @return Response
     */
    public function actionGet(): Response
    {
        if (!empty(Yii::$app->request->get('code'))) {
            $user = UserOpenApi::findByCodeApi(Yii::$app->request->get('code'));
            if ($user) {
                return $this->asJson($user->getUserInArrayApi());
            } else {
                return $this->asJson([
                    'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_USER_NOT_FOUND)
                ]);
            }
        } else {
            return $this->asJson([
                'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_EMPTY_CODE_USER)
            ]);
        }
    }

    /**
     * Возвращает коды конкурсов пользователя по коду пользователя
     * @return Response
     */
    public function actionRaffles(): Response
    {
        if (!empty(Yii::$app->request->get('code'))) {
            $user = UserOpenApi::findByCodeApi(Yii::$app->request->get('code'));
            if ($user) {
                $raffles = $user->getCodesRafflesApi();
                return $this->asJson($raffles);
            } else {
                return $this->asJson([
                    'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_USER_NOT_FOUND)
                ]);
            }
        } else {
            return $this->asJson([
                'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_EMPTY_CODE_USER)
            ]);
        }
    }

    /**
     * Возвращает количество подписчиков
     * @return Response
     */
    public function actionCountsubscribers(): Response
    {
        return $this->asJson([UserOpenApi::getCountSubscribers(Yii::$app->request->get('code'))['count']]);
    }

    /**
     * Возвращает количество подписок
     * @param string $code
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionCountsubscriptions(): Response
    {
        return $this->asJson([UserOpenApi::getCountSubscriptions(Yii::$app->request->get('code'))['count']]);
    }

    /**
     * Подписываемся на пользователя
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function actionSubscribe()
    {
        //TODO дописать
        return Yii::$app->request->post('token');
    }
}
