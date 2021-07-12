<?php
/**
 * RaffleController
 * Контроллер предназначеный для работы с конкурсами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\controllers;

use app\models\db\Raffle;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\db\search\RaffleSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\db\User;
use app\models\db\forms\RaffleForm;

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
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'list'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN, User::ROLE_GUEST],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
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
     * Список конкурсов
     * @return string
     */
    public function actionIndex()
    {
        $Users = ArrayHelper::map(User::find()->all(), 'id', 'username');
        $Raffles = Raffle::find()->where(['status_id' => Raffle::STATUS_APPROVED_ID])->orderBy('id DESC')->limit(30)->all();
        return $this->render('index',[
            'Raffles' => $Raffles,
            'Users' => $Users,
        ]);
    }

    /**
     * Список конкурсов пользователя
     * @return string
     */
    public function actionList($code)
    {
        if(($user = User::findByCode($code)) === null){
            return $this->redirect('/index');
        }

        if($user->id === Yii::$app->user->identity->getId() || (in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMIN_ID, User::ROLE_MODERATOR_ID]))){
            $query = Raffle::find()->where(['user_id' => $user->id]);
        }else{
            $query = Raffle::find()->where(['user_id' => $user->id, 'status_id' => Raffle::STATUS_APPROVED_ID]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'user' => $user
        ]);
    }

    /**
     * Просмотр конкурса
     * @param $code string
     * @return string|Response
     */
    public function actionView($code)
    {
        if(($raffle = Raffle::findByCode($code)) == null){
            return $this->redirect(['index']);
        }elseif($raffle->status_id !== Raffle::STATUS_APPROVED_ID){
            return $this->redirect(['index']);
        }

        return $this->render('view', [
            'model' => $raffle,
            'author' => $raffle->getUser(),
        ]);
    }

    /**
     * Страница добавления конкурса
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new RaffleForm();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->saveRaffle()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Страница редактирование конкурса
     * @param $code string
     * @return string|Response
     */
    public function actionUpdate($code)
    {

        if(($code_old = Yii::$app->request->post('code_old')) == ''){
            if(($raffle = Raffle::findByCode($code)) == null){
                return $this->redirect(['index']);
            }
            $model = new RaffleForm();
            $model->setFromRaffle($raffle);

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        $model = new RaffleForm();

        if(($raffle = Raffle::findByCode($code_old)) == null){
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->updateRaffle($raffle)) {
            return $this->redirect(['/show/'.$model->code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }
}
