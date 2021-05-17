<?php

use yii\db\Migration;
use app\models\db\RaffleStatus;

/**
 * Class m210422_052229_raffle_status
 */
class m210422_052229_create_raffle_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('raffle_status', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->unique()->notNull(),
        ]);

        $this->createIndex(
            'idx-raffle_status-id',
            'raffle_status',
            'id'
        );

        $approved = new RaffleStatus();
        $approved->title = "approved";
        $approved->save();

        $on_check = new RaffleStatus();
        $on_check->title = "on check";
        $on_check->save();

        $not_approved = new RaffleStatus();
        $not_approved->title = "not approved";
        $not_approved->save();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-raffle_status-id',
            'raffle_status'
        );

        $this->dropTable('raffle_status');
    }
}
