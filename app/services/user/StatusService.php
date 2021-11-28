<?php
namespace app\services\user;

use app\models\db\User;

class StatusService
{
    const STATUSES_BANNED = [
        User::STATUS_BAN_ID
    ];

    /**
     * @param User $user
     * @return bool
     */
    public static function checkStatusBanUser(User $user): bool
    {
        return in_array($user->status_id, self::STATUSES_BANNED);
    }
}