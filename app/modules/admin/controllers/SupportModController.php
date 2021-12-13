<?php
/**
 * SupportModController
 * Контроллер модуля admin для модерации обращений
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use app\models\base\search\SupportSearch;
use yii\web\Response;

class SupportModController extends SupportController
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
    public function actionIndex(): string
    {
        $searchModel = new SupportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Метод помечает обращение как "важное".
     * @param int $id
     * @return Response
     */
    public function actionTag(int $id): Response
    {
        $support = $this->findModel($id);
        if ($support === null) {
            return $this->redirect(Url::to('/admin/support-mod/index'));
        }
        $support->setTag();
        return $this->redirect(Url::to(['/admin/support/view', 'id' => $support->id]));
    }

    /**
     * Метод убирает метку "важное" на обращении.
     * @param int $id
     * @return Response
     */
    public function actionUntag(int $id): Response
    {
        $support = $this->findModel($id);
        if ($support === null) {
            return $this->redirect(Url::to('/admin/support-mod/index'));
        }
        $support->setViewed();
        return $this->redirect(Url::to(['/admin/support/view', 'id' => $support->id]));
    }
}
