<?php
/**
 * BaseController
 * Base Контроллер модуля api/shut по Конкурсам
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\api\modules\shut\controllers;

use app\models\system\Lang;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\base\User;

/**
 * BaseController for the `api/shut` module
 */
class BaseController extends Controller
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
                        'actions' => ['view', 'tags'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_AUTHORIZED],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->language = 'en';

        $this->checkLangParam();

        return parent::beforeAction($action);
    }

    private function checkLangParam()
    {
        if (!empty(Yii::$app->request->get('lang'))) {
            if(in_array(Yii::$app->request->get('lang'), Lang::getlanguages())){
                $this->changeLang(Yii::$app->request->get('lang'));
            }
        }
    }

    private function changeLang(string $lang)
    {
        Yii::$app->language = $lang;
    }
}
