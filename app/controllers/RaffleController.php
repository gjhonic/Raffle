<?php
/**
 * RaffleController
 * Контроллер предназначеный для работы с конкурсами
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\controllers;

use app\models\base\Raffle;
use app\models\base\Tag;
use app\services\raffle\ViewsService;
use app\services\user\StatusService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\base\User;
use app\models\base\forms\RaffleForm;

class RaffleController extends Controller
{
    public function behaviors(): array
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
                'denyCallback' => function () {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'list', 'raffle-by-tag', 'filter'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN, User::ROLE_GUEST],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ]
                ],
            ],
        ];
    }

    public $layout = 'frontend';

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            if (StatusService::checkStatusBanUser(Yii::$app->user->identity)) {
                $this->redirect('/banned');
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Список конкурсов предложка.
     * @return string
     */
    public function actionIndex(): string
    {
        $Raffles = Raffle::getPopularRaffles();
        return $this->render('index', [
            'Raffles' => $Raffles,
        ]);
    }

    /**
     * Список конкурсов c сортировкой.
     * @return string
     */
    public function actionFilter(): string
    {
        return $this->render('filter', [
        ]);
    }

    /**
     * Список конкурсов.
     * @param string|null $tag
     * @return string|Response
     */
    public function actionRaffleByTag(string $tag = null)
    {
        if($tag == null){
            return $this->redirect('/index');
        }
        $Raffles = Raffle::getRafflesByTag($tag);
        return $this->render('raffles-by-tag', [
            'Raffles' => $Raffles,
            'tag' => $tag
        ]);
    }

    /**
     * Список конкурсов пользователя
     * @param string $code
     * @return string|Response
     */
    public function actionList(string $code = null)
    {
        if (($user = User::findByCode($code)) === null) {
            return $this->redirect('/index');
        }

        if ($user->id === Yii::$app->user->identity->getId() || (in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMIN_ID, User::ROLE_MODERATOR_ID]))) {
            $query = Raffle::find()->where(['user_id' => $user->id]);
        } else {
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
     * @param string $code
     * @return string|Response
     */
    public function actionView(string $code)
    {
        $raffle = $this->findModel($code);

        if ($raffle == null) {
            return $this->redirect(['index']);
        } elseif (!(($raffle->status_id == Raffle::STATUS_APPROVED_ID) || (Yii::$app->user->identity->getId() == $raffle->user_id))) {
            return $this->redirect(['index']);
        }

        $Tags = $raffle->tags;

        ViewsService::setView(Yii::$app->request->userIP, $raffle->id);

        return $this->render('view', [
            'raffle' => $raffle,
            'Tags' => $Tags,
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
            return $this->redirect(['/show/' . $model->code]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Страница редактирование конкурса
     * @param string $code
     * @return string|Response
     */
    public function actionUpdate(string $code)
    {
        if (($code_old = Yii::$app->request->post('code_old')) == '') {
            if (($raffle = Raffle::findByCode($code)) == null) {
                return $this->redirect(['index']);
            }
            $model = new RaffleForm();
            $model->setFromRaffle($raffle);

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        $model = new RaffleForm();
        $model->code_old = $code_old;

        if (($raffle = Raffle::findByCode($code_old)) == null) {
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->updateRaffle($raffle)) {
            return $this->redirect(['/show/' . $model->code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Метод сохраняет заметку к конкурсу (AJAX)
     * @return false|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionSaveNote(): Response
    {
        if (!\Yii::$app->request->isAjax) {
            return false;
        }
        $note = Yii::$app->request->post('note');
        $raffle_code = Yii::$app->request->post('raffle_code');

        if (($raffle = Raffle::findByCode($raffle_code)) == null) {
            return false;
        }
        if (!$raffle->isAuthor()) {
            return false;
        }

        if (trim($note) != '') {
            $raffle->note = trim($note);
            $result = $raffle->update();
            return $this->asJson([$result]);
        } else {
            return $this->asJson([false]);
        }
    }

    /**
     * @param string $code
     * @return Raffle|null
     */
    private function findModel(string $code): ?Raffle
    {
        if (($model = Raffle::findByCode($code)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
