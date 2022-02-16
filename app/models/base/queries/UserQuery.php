<?php
namespace app\models\base\queries;

use app\models\base\User;
use app\services\user\StatusService;
use yii\db\ActiveQuery;

/**
 * Класс для scope методов
 */
class UserQuery extends ActiveQuery
{
    /**
     * Фильтрация по роли 'пользователь'
     */
    public function getUserByUserRole(): self
    {
        return $this->andWhere(['user.role_id' => User::ROLE_USER_ID]);
    }

    /**
     * Фильтрация по активным статусам
     */
    public function getActiveUser(): self
    {
        return $this->andWhere(['not in', 'user.status_id', StatusService::statusBanned()]);
    }
}