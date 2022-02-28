<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%action_cron}}`.
 */
class m220228_142618_create_action_cron_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%action_cron}}', [
            'id' => $this->primaryKey(),
            'controller' => $this->string(50)->notNull(),
            'action' => $this->string(50)->notNull(),
            'result' => $this->integer(1)->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-action_cron-id',
            'action_cron',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-action_cron-id',
            'action_cron'
        );

        $this->dropTable('{{%action_cron}}');
    }
}
