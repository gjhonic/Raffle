<?php
/**
 * MainController
 * Главные Контроллер модуля api/open
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\modules\open\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;

/**
 * Default controller for the `api/open` module
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
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    /**
     * Docs api public.
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('/../../../views/index', [
            'swagger_name' => 'swagger'
        ]);
    }
}
