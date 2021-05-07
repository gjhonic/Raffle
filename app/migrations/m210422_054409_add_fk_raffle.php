<?php

use yii\db\Migration;

/**
 * Class m210422_054409_add_fk_raffle
 */
class m210422_054409_add_fk_raffle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-raffle-user_id',
            'raffle',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-raffle-status_id',
            'raffle',
            'status_id',
            'raffle_status',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-raffle-user_id',
            'raffle'
        );

        $this->dropForeignKey(
            'fk-raffle-status_id',
            'raffle'
        );
    }

}
