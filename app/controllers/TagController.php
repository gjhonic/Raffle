<?php
/**
 * TagController
 * Контроллер предназначеный для работы с тегами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\controllers;

use app\models\base\Tag;
use app\services\user\StatusService;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\base\User;

class TagController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN, User::ROLE_GUEST],
                    ],
                ],
            ],
        ];
    }

    public $layout = 'frontend';

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            if (StatusService::checkStatusBanUser(Yii::$app->user->identity)) {
                $this->redirect('/banned');
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Список популярных тегов.
     * @return string
     */
    public function actionIndex(): string
    {
        $tags = Tag::getPopularTags();
        return $this->render('index', [
            'tags' => $tags,
        ]);
    }

    /**
     * @param string $title
     * @return Tag|null
     */
    private function findModel(string $title): ?Tag
    {
        if (($model = Tag::findOne(['title' => $title])) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
