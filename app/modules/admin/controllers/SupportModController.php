<?php

/**
 * SupportModController
 * Контроллер модуля admin для модерации обращений
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use app\models\db\Support;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;
use app\models\db\search\SupportSearch;

class SupportModController extends Controller
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
                        'actions' => ['index', 'tag', 'untag'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр список обращений.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Метод помечает обращение как "важное"
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTag($id){
        $support = Support::findOne($id);
        if($support === null){
            return $this->redirect(Url::to('/admin/support-mod/index'));
        }
        $support->setTag();
        return $this->redirect(Url::to(['/admin/support/view', 'id' => $support->id]));
    }

    /**
     * Метод cнимает метку "важное" на обращении
     * @param $id int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUntag($id){
        $support = Support::findOne($id);
        if($support === null){
            return $this->redirect(Url::to('/admin/support-mod/index'));
        }
        $support->setViewed();
        return $this->redirect(Url::to(['/admin/support/view', 'id' => $support->id]));
    }
}
