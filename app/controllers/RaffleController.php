<?php

namespace app\controllers;

use app\models\db\Raffle;
use app\models\db\RaffleStatus;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\db\User;
use app\models\db\forms\RaffleForm;

class RaffleController extends Controller
{

    public function behaviors()
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
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => [User::ROLE_USER,User::ROLE_MODERATOR,User::ROLE_ADMIN,User::ROLE_GUEST],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public $layout = 'frontend';

    public function beforeAction($action)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->status_id == User::STATUS_BAN_ID){
                Yii::$app->user->logout();
                if(isset($session))
                    $session->destroy();
                echo "<h1>Ты забанен!!!</h1>";
                die;
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * Список конкурсов
     * @return string
     */
    public function actionIndex()
    {
        $Raffles = Raffle::find()->where(['status_id' => Raffle::STATUS_APPROVED_ID])->orderBy('id DESC')->limit(30)->all();
        return $this->render('index',[
            'Raffles' => $Raffles,
        ]);
    }

    /**
     * Просмотр конкурса
     * @param $code string
     * @return string|Response
     */
    public function actionView($code)
    {
        if(($raffle = Raffle::findByCode($code)) == null){
            return $this->redirect(['index']);
        }elseif($raffle->status_id !== Raffle::STATUS_APPROVED_ID){
            return $this->redirect(['index']);
        }

        return $this->render('view', [
            'model' => $raffle,
        ]);
    }

    /**
     * Страница добавления конкурса
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new RaffleForm();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->saveRaffle()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
