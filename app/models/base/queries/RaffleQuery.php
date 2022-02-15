<?php
namespace app\models\base\queries;

use app\models\base\Raffle;
use yii\db\ActiveQuery;

/**
 * Класс для scope методов
 */
class RaffleQuery extends ActiveQuery
{
    /**
     * Фильтрация по статусу 'одобрено'
     */
    public function getApprovedRaffle(): self
    {
        return $this->andWhere(['raffle.status_id' => Raffle::STATUS_APPROVED_ID]);
    }
}