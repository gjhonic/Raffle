<?php
/**
 * RaffleController
 * Контроллер модуля api/shut
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\shut\controllers;

use app\modules\api\models\ErrorApi;
use Yii;
use app\modules\api\modules\shut\models\RaffleShutApi;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use yii\web\Response;

/**
 * Default controller for the `api/shut` module
 */
class RaffleController extends BaseController
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
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionView(): Response
    {
        if (!empty(Yii::$app->request->get('code'))) {
            $raffle = RaffleShutApi::findByCode(Yii::$app->request->get('code'));
            if ($raffle) {
                return $this->asJson($raffle);
            } else {
                return $this->asJson([
                    'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_RAFFLE_NOT_FOUND)
                ]);
            }
        } else {
            return $this->asJson([
                'error' => ErrorApi::getDescriptionError(ErrorApi::ERROR_EMPTY_CODE_RAFFLE)
            ]);
        }
    }
}
