<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%active_record_create_log}}` and `{{%active_record_change_log}}`.
 */
class m210422_052230_create_active_record_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%active_record_create_log}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'action' => $this->integer()->notNull(),
            'model' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%active_record_change_log}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'model' => $this->string(255)->notNull(),
            'field' => $this->string(255),
            'old_value' => $this->string(255),
            'new_value' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%active_record_create_log}}');
        $this->dropTable('{{%active_record_change_log}}');
    }
}
