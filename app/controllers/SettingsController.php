<?php

namespace app\controllers;

use app\services\user\StatusService;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\base\User;
use app\models\base\forms\SettingForm;
use app\models\base\forms\SettingPasswordForm;

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
            if(StatusService::checkStatusBanUser(Yii::$app->user->identity)){
                $this->redirect('/banned');
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Страница отображения настроек
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Страница отображения настроек account
     * @return string
     */
    public function actionAccount()
    {
        $model = new SettingForm();
        $model->saveSettings();
        return $this->render('basic-settings', [
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
            'model' => $model,
        ]);
    }
}
