<?php
/**
 * SupportController
 * Контроллер модуля admin для работы с обращениями
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\Support;
use app\models\db\User;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SupportController extends Controller
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
                        'actions' => ['view', 'delete'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр обращения.
     * @param int $id
     * @return string|Response
     */
    public function actionView(int $id)
    {
        $support = $this->findModel($id);

        if ($support === null) {
            return $this->redirect(Url::to('/admin/support-mod/index'));
        }
        if ($support->status === Support::STATUS_NOT_VIEWED) {
            $support->setViewed();
        }
        return $this->render('view', [
            'model' => $support,
        ]);
    }

    /**
     * Удаление обращения.
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $support = $this->findModel($id);
        if ($support->delete()) {
            return $this->redirect(['/admin/support-mod/index']);
        } else {
            return $this->redirect(['view', 'id' => $support->id]);
        }
    }

    /**
     * @param int $id
     * @return Support|null
     */
    protected function findModel(int $id): ?Support
    {
        if (($model = Support::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
