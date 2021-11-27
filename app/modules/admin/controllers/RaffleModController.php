<?php
/**
 * RaffleModController
 * Контроллер модуля admin для модерации пользователей системы
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use app\models\db\Raffle;
use Throwable;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;
use app\models\db\search\RaffleSearch;
use yii\web\Response;

class RaffleModController extends Controller
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
                        'actions' => ['index', 'ban', 'unban'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр список конкурсов.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new RaffleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Метод запрещает конкурс.
     * @param int $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBan(int $id): Response
    {
        $raffle = Raffle::findOne($id);
        if ($raffle !== null) {
            $raffle->status_id = Raffle::STATUS_NOT_APPROVED_ID;
            $raffle->update();
        }
        return $this->redirect(Url::to('/admin/raffle-mod/index'));
    }

    /**
     * Метод одобряет конкурс.
     * @param int $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnban(int $id): Response
    {
        $raffle = Raffle::findOne($id);
        if ($raffle != null) {
            $raffle->status_id = Raffle::STATUS_APPROVED_ID;
            $raffle->update();
        }
        return $this->redirect(Url::to('/admin/raffle-mod/index'));
    }
}
