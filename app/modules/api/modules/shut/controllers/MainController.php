<?php
/**
 * MainController
 * Главные Контроллер модуля api/shut
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\shut\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\db\User;

/**
 * Default controller for the `api/shut` module
 */
class MainController extends Controller
{
    //TODO Переписать метод авторизации для приватного апи
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
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MODERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Docs api private.
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('/../../../views/index', [
            'swagger_name' => 'swagger_private'
        ]);
    }
}