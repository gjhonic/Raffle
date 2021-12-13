<?php
/**
 * RaffleController
 * Контроллер модуля api/open по Конкурсам
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\open\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use app\modules\api\modules\open\models\RaffleOpenApi;
use yii\web\Response;

/**
 * Controller for the `api/open` module
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
                        'actions' => ['view', 'tags'],
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
        return $this->asJson([RaffleOpenApi::findByCode(Yii::$app->request->get('code'))]);
    }

    /**
     * Возвращает теги конкурса
     * @param string $code
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionTags(): Response
    {
        return $this->asJson([RaffleOpenApi::getTagsRaffle(Yii::$app->request->get('code'))]);
    }
}
