<?php

use yii\db\Migration;

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
