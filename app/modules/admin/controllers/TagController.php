<?php
/**
 * TagController
 * Контроллер модуля admin для работы с тегами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\Tag;
use app\models\db\User;
use app\models\db\search\TagSearch;
use yii\web\Response;


class TagController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр список тегов.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Просмотр тега.
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Добавление тега.
     * @return string|Response
     */
    public function actionCreate()
    {
        $tag = new Tag();
        if ($tag->load(Yii::$app->request->post()) && $tag->save()) {
            return $this->redirect(['view', 'id' => $tag->id]);
        }

        return $this->render('create', [
            'model' => $tag,
        ]);
    }

    /**
     * Изменение тега.
     * @param int $id
     * @return string|Response
     */
    public function actionUpdate(int $id)
    {
        $tag = Tag::findOne($id);
        if ($tag->load(Yii::$app->request->post()) && $tag->update()) {
            return $this->redirect(['view', 'id' => $tag->id]);
        }

        return $this->render('update', [
            'model' => $tag,
        ]);
    }

    /**
     * Удаление тега тега.
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $tag = $this->findModel($id);
        if ($tag->delete()) {
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['view', 'id' => $tag->id]);
        }
    }

    /**
     * @param int $id
     * @return Tag|null
     */
    protected function findModel(int $id): ?Tag
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
