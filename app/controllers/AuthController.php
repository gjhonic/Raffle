<?php
/**
 * AuthController
 * Контроллер предназначеный для аутентификация
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;

//Модели Форм
use app\models\auth\forms\SigninForm;
use app\models\auth\forms\SignupForm;

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
                    'actions' => ['signin','signup','signout'],
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


    public $layout = 'default';

    /**
     * actionLogin - Метод обрабатывает форму аутентификация
     * @return redirect - профиль/ошибка аутентификация
     */  
    // >> ------------------------------------------------- 
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
    // ------------------------------------------------- <<

    /**
     * actionSignup - Метод обрабатывает форму регистрации
     * @return redirect - профиль/ошибка регистрации
     */  
    // >> ------------------------------------------------- 
    public function actionSignup(){

        if (!Yii::$app->user->isGuest) {
            $this->redirect(Url::to(''));
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(Url::to('/profile'));
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    // ------------------------------------------------- <<

    /**
     * actionLogout - Метод выхода из аккаунта
     * @return redirect - homeUrl
     */  
    // >> ------------------------------------------------- 
    public function actionSignout(){

    Yii::$app->user->logout();
    if(isset($session))
        $session->destroy();

    return $this->redirect(Yii::$app->homeUrl);
    }
    // ------------------------------------------------- <<
}
