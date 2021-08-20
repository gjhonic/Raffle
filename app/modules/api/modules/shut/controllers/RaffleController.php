<?php
/**
 * RaffleController
 * Контроллер модуля api/shut
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\shut\controllers;

use Yii;
use app\modules\api\modules\shut\models\RaffleShutApi;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;

/**
 * Default controller for the `api/shut` module
 */
class RaffleController extends Controller
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
                        'actions' => ['view'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает конкурс по коду
     * @param string $code
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function actionView()
    {
        return json_encode(RaffleShutApi::findByCode(Yii::$app->request->get('code')));
    }
}
