<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\db\User;

class SiteController extends Controller
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
                        'actions' => ['profile','index', 'about'],
                        'roles' => [User::ROLE_USER,User::ROLE_MODERATOR,User::ROLE_ADMIN],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'test'],
                        'roles' => [User::ROLE_GUEST,User::ROLE_USER,User::ROLE_MODERATOR,User::ROLE_ADMIN],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     * @param string
     * @return Response|string
     */
    public function actionProfile($code=null)
    {
        if($code==null && Yii::$app->user->isGuest){
            return $this->redirect(['index']);
        }
        $user = ($code!=null) ? User::findByCode($code) : User::currentUser();

        if(!$user){
            return $this->redirect(['index']);
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionTest()
    {

    }
}
