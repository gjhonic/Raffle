<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%d_raffle_view}}`.
 */
class m220217_150753_created_raffle_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%raffle_view}}', [
            'id' => $this->primaryKey(),
            'address_id' => $this->integer()->notNull(),
            'raffle_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-raffle_view-id',
            'raffle_view',
            'id'
        );

        $this->addForeignKey(
            'fk-address_id-raffle_view',
            'raffle_view',
            'address_id',
            'addresses',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-raffle_id-raffle_view',
            'raffle_view',
            'raffle_id',
            'raffle',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-raffle_view-id',
            'raffle_view'
        );

        $this->dropForeignKey(
            'fk-address_id-action_api',
            'raffle_view'
        );

        $this->dropForeignKey(
            'fk-raffle_id-action_api',
            'raffle_view'
        );

        $this->dropTable('{{%raffle_view}}');
    }
}
