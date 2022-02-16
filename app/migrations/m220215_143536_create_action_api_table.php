<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%action_api}}`.
 */
class m220215_143536_create_action_api_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%action_api}}', [
            'id' => $this->primaryKey(),
            'address_id' => $this->integer()->notNull(),
            'method' => $this->string(50)->notNull(),
            'version' => $this->string(10)->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-action_api-id',
            'action_api',
            'id'
        );

        $this->addForeignKey(
            'fk-address_id-action_api',
            'action_api',
            'address_id',
            'addresses',
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
            'idx-action_api-id',
            'action_api'
        );

        $this->dropForeignKey(
            'fk-address_id-action_api',
            'action_api'
        );

        $this->dropTable('{{%action_api}}');
    }
}
