<?php
/**
 * RaffleController
 * Контроллер модуля admin для работы с конкурсами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use app\models\base\Address;
use app\modules\admin\models\search\AddressSearch;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;
use yii\web\Response;

class AddressController extends Controller
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
                        'actions' => ['index', 'view', 'update'],
                        'roles' => [User::ROLE_ADMIN],
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
        $searchModel = new AddressSearch();
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
        $address = $this->findModel($id);
        if ($address === null) {
            return $this->redirect(Url::to('/admin/address/'));
        }
        return $this->render('view', [
            'model' => $address,
        ]);
    }

    /**
     * Изменение тега.
     * @param int $id
     * @return string|Response
     */
    public function actionUpdate(int $id)
    {
        $address = $this->findModel($id);
        if ($address->load(Yii::$app->request->post()) && $address->update()) {
            return $this->redirect(['view', 'id' => $address->id]);
        }

        return $this->render('update', [
            'model' => $address,
        ]);
    }

    /**
     * @param int $id
     * @return Address|null
     */
    protected function findModel(int $id): ?Address
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
