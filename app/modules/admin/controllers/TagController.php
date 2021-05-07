<?php

/**
 * TagController
 * Контроллер модуля admin для работы с тегами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\Tag;
use app\models\db\User;
use app\models\db\search\TagSearch;


class TagController extends Controller
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
                        'actions' => ['index','view','create','update','delete'],
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
    public function actionIndex()
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
     * @param $id integer
     * @return string
     */
    public function actionView($id)
    {
        $tag = Tag::findOne($id);
        return $this->render('view', [
            'model' => $tag,
        ]);
    }

    /**
     * Добавление тега.
     * @return string
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
     * @param $id integer
     * @return string
     */
    public function actionUpdate($id)
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
     * @param $id integer
     * @return string
     */
    public function actionDelete($id)
    {
        $tag = Tag::findOne($id);
        if ($tag->delete()) {
            return $this->redirect(['index']);
        }else{
            return $this->redirect(['view', 'id' => $tag->id]);
        }

    }
}
