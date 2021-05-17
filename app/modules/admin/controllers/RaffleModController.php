<?php

/**
 * RaffleModController
 * Контроллер модуля admin для модерации пользователей системы
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\admin\controllers;

use app\models\db\Raffle;
use app\models\db\UserRole;
use app\models\db\UserStatus;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;
use app\models\db\search\RaffleSearch;

class RaffleModController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('signin'));
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
    public function actionIndex()
    {
        $searchModel = new RaffleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Метод запрещает конкурс
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBan($id)
    {
        $raffle = Raffle::findOne($id);
        if($raffle != null){
            $raffle->status_id = 3;
            $raffle->update();
        }
        $this->redirect(Url::to('/admin/raffle-mod/index'));
    }

    /**
     * Метод одобряет конкурс
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnban($id)
    {
        $raffle = Raffle::findOne($id);
        if($raffle != null){
            $raffle->status_id = 2;
            $raffle->update();
        }
        $this->redirect(Url::to('/admin/raffle-mod/index'));
    }
}
