<?php
/**
 * RaffleController
 * Контроллер модуля admin для работы с конкурсами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\Raffle;
use app\models\db\User;
use app\models\db\search\RaffleSearch;
use yii\web\Response;

class RaffleController extends Controller
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
     * Страница конкурса.
     * @param int $id
     * @return string|Response
     */
    public function actionView(int $id)
    {
        $raffle = $this->findModel($id);
        if ($raffle === null) {
            return $this->redirect(Url::to('/admin/raffle/'));
        }
        return $this->render('view', [
            'model' => $raffle,
        ]);
    }

    /**
     * @param int $id
     * @return Raffle|null
     */
    protected function findModel(int $id): ?Raffle
    {
        if (($model = Raffle::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
