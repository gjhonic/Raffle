<?php
/**
 * UserController
 * Контроллер модуля api/open по Пользователям
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\open\controllers;

use Yii;
use app\models\db\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\modules\api\modules\open\models\UserOpenApi;
use yii\web\Response;

/**
 * Controller for the `api/open` module
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
                        'actions' => ['view', 'countsubscribers', 'countsubscriptions', 'subscribe'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Возвращает пользователя по коду
     * @param string $code
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionView()
    {
        return $this->asJson([UserOpenApi::findByCode(Yii::$app->request->get('code'))]);
    }

    /**
     * Возвращает количество подписчиков
     * @param string $code
     * @return Response
     * @throws \yii\db\Exception
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
