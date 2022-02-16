<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addresses}}`.
 */
class m210422_052231_create_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addresses}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string()->unique()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'note' => $this->string()->null(),
            'description' => $this->string()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-addresses-id',
            'addresses',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-addresses-id',
            'addresses'
        );

        $this->dropTable('{{%addresses}}');
    }
}
