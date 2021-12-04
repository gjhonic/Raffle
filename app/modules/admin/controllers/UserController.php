<?php
/**
 * UserController
 * Контроллер модуля admin для работы с пользователями системы
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use app\models\base\UserRole;
use app\modules\admin\models\forms\ModeratorForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use app\models\base\search\UserSearch;
use yii\web\Response;

class UserController extends Controller
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
                        'actions' => ['index', 'view'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'Roles' => ArrayHelper::map(UserRole::find()->all(), 'id', 'title'),
        ]);
    }

    /**
     * Просмотр пользователя.
     * @param int $id
     * @return string
     */
    public function actionView(int $id)
    {
        $user = User::findOne($id);
        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Добавление пользователя с ролью 'Модератор'.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new ModeratorForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(Url::to(['/admin/user/view', 'id' => $model->user->id]));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
