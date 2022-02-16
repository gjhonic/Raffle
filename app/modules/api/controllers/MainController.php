<?php
/**
 * MainController
 * Главный Контроллер модуля api
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\controllers;

use app\models\base\User;
use app\modules\api\models\search\ActionApiSearch;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * MainController for the `api` module
 */
class MainController extends Controller
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
                        'actions' => ['index', 'log'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    public $layout = 'main.php';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLog()
    {
        $searchModel = new ActionApiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('log', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
}
