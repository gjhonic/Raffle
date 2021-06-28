<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\db\User;
use app\models\db\forms\SettingForm;
use app\models\db\forms\SettingPasswordForm;

class SettingsController extends Controller
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
                        'actions' => ['index', 'account', 'password'],
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
     * Страница отображения настроек
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'user' => User::currentUser(),
        ]);
    }

    /**
     * Страница отображения настроек account
     * @return string
     */
    public function actionAccount()
    {
        $model = new SettingForm();
        $model->saveSettings();
        return $this->render('account', [
            'user' => User::currentUser(),
            'model' => $model,
        ]);
    }

    /**
     * Страница отображения настроек password
     * @return \yii\web\Response|string
     */
    public function actionPassword()
    {
        $model = new SettingPasswordForm();

        if ($model->saveSettings()){
            return $this->redirect(['index']);
        }
        return $this->render('password', [
            'user' => User::currentUser(),
            'model' => $model,
        ]);
    }
}
