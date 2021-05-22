<?php
/**
 * MainController
 * Главные Контроллер модуля admin
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\controllers;

use app\models\db\Raffle;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;

/**
 * Default controller for the `admin` module
 */
class MainController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR, User::ROLE_GUEST],
                    ],
                ],
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $Raffle = Raffle::find()->one();
        echo '{';
        echo 'title: "'.$Raffle->title.'", ';
        echo 'user_id: "'.$Raffle->user_id.'", ';
        echo 'short_description: "'.$Raffle->short_description.'", ';
        echo 'description: "'.$Raffle->description.'", }';
        die;
    }
}
