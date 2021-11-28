<?php

namespace app\controllers;

use app\models\db\forms\SupportForm;
use app\models\db\Raffle;
use app\models\base\Tag;
use app\services\user\StatusService;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\db\User;

class SiteController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    $this->redirect(Url::to('/signin'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['profile', 'index', 'about', 'support', 'banned'],
                        'roles' => [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'search'],
                        'roles' => [User::ROLE_GUEST, User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public $layout = 'frontend';

    public function beforeAction($action)
    {
        if(!Yii::$app->user->isGuest && $action->id != 'banned'){
            if(StatusService::checkStatusBanUser(Yii::$app->user->identity)){
                return $this->redirect('/banned');
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * Главная страница.
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Профиль пользователя.
     * @param string
     * @return Response|string
     */
    public function actionProfile($code = null)
    {
        $user = ($code != null) ? User::findByCode($code) : User::currentUser();

        if (!$user) {
            return $this->redirect(['index']);
        }

        $RafflesApproved = Raffle::findRafflesByUser($user->id, Raffle::STATUS_APPROVED_ID);
        if ($user->id === Yii::$app->user->identity->getId()) {

            $RafflesChecked = Raffle::findRafflesByUser($user->id, Raffle::STATUS_ON_CHECK_ID);
            $RafflesNotApproved = Raffle::findRafflesByUser($user->id, Raffle::STATUS_NOT_APPROVED_ID);
            return $this->render('profile', [
                'user' => $user,
                'RafflesApproved' => $RafflesApproved,
                'RafflesChecked' => $RafflesChecked,
                'RafflesNotApproved' => $RafflesNotApproved
            ]);
        } else {
            return $this->render('profile', [
                'user' => $user,
                'RafflesApproved' => $RafflesApproved,
            ]);
        }
    }

    /**
     * Страница формы поддержки.
     * @return string|Response
     */
    public function actionSupport()
    {
        $model = new SupportForm();

        if ($model->load(Yii::$app->request->post()) && $model->sendSupport()) {
            return $this->redirect(['index']);
        }

        return $this->render('support', ['model' => $model]);
    }

    /**
     * Страница найденного контента.
     * @return string|Response
     */
    public function actionSearch(string $q)
    {
        if (($q = trim($q)) === '') {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $Raffles = Raffle::searchRaffles($q);
        $Users = User::searchUsers($q);
        $Tags = Tag::searchTags($q);

        return $this->render('search', [
            'query' => $q,
            'Raffles' => $Raffles,
            'Users' => $Users,
            'Tags' => $Tags
        ]);
    }

    /**
     * Страница заблокированного пользователя.
     * @return string|Response
     */
    public function actionBanned()
    {
        $user = User::currentUser();
        if(!StatusService::checkStatusBanUser($user)){
            return $this->redirect('index');
        }
        return $this->render('banned');
    }
}
