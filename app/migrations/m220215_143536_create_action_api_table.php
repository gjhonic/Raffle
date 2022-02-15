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
            'addresses_id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%action_api}}');
    }
}
