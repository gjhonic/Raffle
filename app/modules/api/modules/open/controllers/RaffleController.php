<?php
/**
 * RaffleController
 * Контроллер модуля api/open по Конкурсам
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\api\modules\open\controllers;

use app\models\base\Raffle;
use app\modules\api\models\ErrorApi;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use app\modules\api\modules\open\models\RaffleOpenApi;
use yii\web\Response;

/**
 * Controller for the `api/open` module
 */
class RaffleController extends BaseController
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
                        'actions' => ['get', 'tags'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает конкурс по коду
     * @return Response
     */
    public function actionGet(): Response
    {
        if (!empty(Yii::$app->request->get('code'))) {
            $raffle = RaffleOpenApi::findByCode(Yii::$app->request->get('code'));
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

    /**
     * Возвращает теги конкурса
     * @return Response
     */
    public function actionTags(): Response
    {
        if (!empty(Yii::$app->request->get('code'))) {
            $raffle = Raffle::findByCode(Yii::$app->request->get('code'));
            if ($raffle) {
                $tagsArray = [];
                $Tags = $raffle->tags;
                $tag_item = [];
                foreach ($Tags as $tag) {
                    $tag_item['title'] = $tag->title;
                    $tagsArray[] = $tag_item;
                }

                return $this->asJson($tagsArray);
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
