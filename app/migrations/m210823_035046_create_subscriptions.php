<?php

use yii\db\Migration;

/**
 * Class m210823_035046_create_subscriptions
 */
class m210823_035046_create_subscriptions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscriptions', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-subscriptions-id',
            'subscriptions',
            'id'
        );

        $this->addForeignKey(
            'fk-subscriptions-user_id',
            'subscriptions',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-subscriptions-subscriber_id',
            'subscriptions',
            'subscriber_id',
            'user',
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
            'idx-subscriptions-id',
            'subscriptions'
        );

        $this->dropForeignKey(
            'fk-subscriptions-user_id',
            'subscriptions'
        );

        $this->dropForeignKey(
            'fk-subscriptions-subscriber_id',
            'subscriptions'
        );

        $this->dropTable('subscriptions');
    }
}
