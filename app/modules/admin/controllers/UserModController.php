<?php
/**
 * UserModController
 * Контроллер модуля admin для модерации пользователей системы
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use app\models\base\search\UserSearch;
use yii\web\Response;

class UserModController extends UserController
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
                        'actions' => ['index', 'view', 'tag', 'untag'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin', 'ban', 'unban'],
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр список пользователей.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'moder');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Просмотр список пользователей c админскими возможностями.
     * @return string
     */
    public function actionAdmin(): string
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'admin');

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Просмотр пользователя.
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => User::findOne($id),
        ]);
    }

    /**
     * Метод помечает пользователя на бан
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTag(int $id): Response
    {
        $user = User::findOne($id);

        if ($user->role_id !== User::ROLE_ADMIN_ID && $user->id !== Yii::$app->user->id) {
            $user->status_id = User::STATUS_TAG_TO_BAN_ID;
            $user->update();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Метод отмечает пользователя
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUntag(int $id): Response
    {
        $user = User::findOne($id);

        if ($user->role_id !== User::ROLE_ADMIN_ID && $user->id !== Yii::$app->user->identity->id) {
            $user->status_id = User::STATUS_ACTIVE_ID;
            $user->update();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Метод банить пользователя
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBan(int $id): Response
    {
        $user = User::findOne($id);

        if ($user->role_id !== User::ROLE_ADMIN_ID) {
            $user->status_id = User::STATUS_BAN_ID;
            $user->update();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Метод разбанивает пользователя
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnban(int $id): Response
    {
        $user = User::findOne($id);

        if ($user->role_id !== User::ROLE_ADMIN_ID) {
            $user->status_id = User::STATUS_TAG_TO_BAN_ID;
            $user->update();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}
