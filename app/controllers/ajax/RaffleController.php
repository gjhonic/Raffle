<?php
/**
 * RaffleController
 * Контроллер предназначеный для работы с конкурсами по Ajax
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\controllers\ajax;

use app\models\db\Raffle;
use Yii;
use app\services\user\StatusService;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\db\User;

class RaffleController extends Controller
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
                    //AJAX
                    [
                        'allow' => true,
                        'actions' => ['save-note', 'get-raffles-json'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ]
                ],
            ],
        ];
    }

    /**
     * Метод сохраняет заметку к конкурсу (AJAX)
     * @return false|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionSaveNote(): Response
    {
        if(!\Yii::$app->request->isAjax){
            return false;
        }
        $note = Yii::$app->request->post('note');
        $raffle_code = Yii::$app->request->post('raffle_code');

        if(($raffle = Raffle::findByCode($raffle_code)) == null){
            return false;
        }
        if(!$raffle->isAuthor()){
            return false;
        }

        if(trim($note) != ''){
            $raffle->note = trim($note);
            $result = $raffle->update();
            return $this->asJson([$result]);
        }else{
            return $this->asJson([false]);
        }
    }

    /**
     * Возвращает список конкурсов по json
     * @return Response|false
     * @throws \yii\db\Exception
     */
    public function actionGetRafflesJson(): Response
    {
        if(!Yii::$app->request->isAjax){
            return false;
        }
        $filter = [];
        $page = 0;
        if(Yii::$app->request->get('filter_date') != ''){
            $filter['filter-date'] = Yii::$app->request->get('filter_date');
        }
        if(Yii::$app->request->get('filter_abc') != ''){
            $filter['filter-abc'] = Yii::$app->request->get('filter_abc');
        }
        if(Yii::$app->request->get('filter_group') != ''){
            $filter['filter-group'] = Yii::$app->request->get('filter_group');
        }
        if(Yii::$app->request->get('page') != ''){
            $page = Yii::$app->request->get('page');
        }
        if(($raffles = Raffle::getPopularRaffles($filter, $page)) != null){
            return $this->asJson(['data' => $raffles]);
        }else{
            return $this->asJson(['data' => false]);
        }
    }

}
