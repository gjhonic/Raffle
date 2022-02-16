<?php
/**
 * BaseController
 * Base Контроллер модуля api/open по Конкурсам
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */

namespace app\modules\api\modules\open\controllers;

use app\models\system\Lang;
use app\modules\api\services\ActionApiService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * BaseController for the `api/open` module
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
                        'actions' => [],
                        'roles' => [],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->checkLangParam();

        $method = $action->controller->id. '/' .$action->id;
        $module = $action->controller->module->id;
        $userIp = Yii::$app->request->userIP;

        ActionApiService::addLogUseApi($userIp, $method, $module);
        return parent::beforeAction($action);
    }

    /**
     * Метод проверяет установлен ли параметр lang
     * @return void
     */
    private function checkLangParam(): void
    {
        if (!empty(Yii::$app->request->get('lang'))) {
            if(in_array(Yii::$app->request->get('lang'), Lang::getlanguages())){
                $this->setLang(Yii::$app->request->get('lang'));
            }
        } else {
            $this->setLang(Lang::LANG_EN);
        }
    }

    /**
     * Метод изменяет язык приложения
     * @param string $lang
     * @return void
     */
    private function setLang(string $lang): void
    {
        Yii::$app->language = $lang;
    }
}
