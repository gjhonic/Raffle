<?php
/**
 * AuthController
 * Контроллер предназначеный для аутентификация
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\controllers;

use app\models\auth\forms\ConfirmEmailForm;
use app\models\auth\UserIdentity;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use app\components\mail\SendCodeMail;
use app\models\auth\forms\SigninForm;
use app\models\auth\forms\SignupForm;
use app\models\db\User;


class AuthController extends Controller
{

    public function behaviors(){
        return [
            'access' => [
            'class' => AccessControl::className(),
            'denyCallback' => function ($rule, $action) {
            $this->redirect('signin');
            },
            'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signin','signup','signout','confirm-email'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public $layout = 'auth';

    /**
     * actionLogin - Метод обрабатывает форму аутентификация
     * @return string|Response
     */
    public function actionSignin(){

        if (!Yii::$app->user->isGuest) {
            return  $this->redirect(Url::to('/profile'));
        }

        $model = new SigninForm();

        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            return $this->redirect(Url::to('/profile'));
        }

        return $this->render('signin', [
            'model' => $model,
        ]);
    }

    /**
     * actionSignup - Метод обрабатывает форму регистрации
     * @return string|Response
     */
    public function actionSignup(){

        if (!Yii::$app->user->isGuest) {
            $this->redirect(Url::to('index'));
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $session = Yii::$app->session;
            $session['user_registr'] = $model->user->id;
            return $this->redirect('confirm-email');
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * actionConfirmEmail - Метод подтверждает почту
     * @return string|Response
     */
    public function actionConfirmEmail(){

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Url::to('index'));
        }
        $session = Yii::$app->session;
        if(!isset($session['user_registr'])){
            return $this->redirect(Url::to('index'));
        }

        $user = User::findOne($session['user_registr']);
        $model = new ConfirmEmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(isset($session['code_confirm'])){
                if($model->code == $session['code_confirm']){
                    $user->email_confirm = 1;
                    $user->update();
                    $session->remove('code_confirm');
                    $session->remove('user_registr');
                    Yii::$app->user->login(UserIdentity::findByUsername($user->username), 3600*24*30);
                    return $this->redirect(Url::to('/profile'));
                }else{
                    $model->addError('code', 'Не верный код');
                    $model->code = '';
                    return $this->render('confirm-mail', [
                        'model' => $model,
                    ]);
                }
            }
        }

        $title = "Регистрация на сайте raffle.ru";
        $message = "Вашу почту указали при регистрации на сайте Raffle.ru";
        $mail = $user->email;
        $code = mt_rand(10000, 99999);
        if(!SendCodeMail::send($mail, $title, $message, $code)){
            $this->redirect(Url::to('index'));
        }
        $session['code_confirm'] = $code;

        return $this->render('confirm-mail', [
            'model' => $model,
        ]);
    }

    private function sendMessageConfirmMail($user_mail){

    }

    /**
     * actionLogout - Метод выхода из аккаунта
     * @return Response
     */
    public function actionSignout(){

    Yii::$app->user->logout();
    if(isset($session))
        $session->destroy();

    return $this->redirect(Yii::$app->homeUrl);
    }
}
