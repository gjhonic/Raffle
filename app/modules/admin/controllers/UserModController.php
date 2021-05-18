<?php

/**
 * UserModController
 * Контроллер модуля admin для модерации пользователей системы
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\admin\controllers;

use app\models\db\UserRole;
use app\models\db\UserStatus;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;
use app\models\db\search\UserSearch;



class UserModController extends Controller
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
    public function actionIndex()
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
    public function actionAdmin()
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
     * @param $id
     * @return string
     */
    public function actionView($id){

        $user = User::findOne($id);
        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Метод помечает пользователя на бан
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTag($id){
        $user = User::findOne($id);

        if($user->role_id !== 1 && $user->id !== Yii::$app->user->id){
            $user->status_id = 2;
            $user->update();
        }

        $this->redirect(Url::to('/admin/user-mod/index'));
    }

    /**
     * Метод отмечает пользователя
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUntag($id){
        $user = User::findOne($id);

        if($user->role_id !== 1 && $user->id !== Yii::$app->user->identity->id){
            $user->status_id = 1;
            $user->update();
        }

        $this->redirect(Url::to('/admin/user-mod/index'));
    }

    /**
     * Метод банить пользователя
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBan($id){
        $user = User::findOne($id);

        if($user->role_id !== 1){
            $user->status_id = 3;
            $user->update();
        }

        $this->redirect(Url::to('/admin/user-mod/admin'));
    }

    /**
     * Метод разбанивает пользователя
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnban($id){
        $user = User::findOne($id);

        if($user->role_id !== 1){
            $user->status_id = 2;
            $user->update();
        }

        $this->redirect(Url::to('/admin/user-mod/admin'));
    }
}
