<?php

use yii\db\Migration;

/**
 * Class m210526_095517_create_support
 */
class m210526_095517_create_support extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('support', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-support-id',
            'support',
            'id'
        );

        $this->addForeignKey(
        'fk-support-user_id',
        'support',
        'user_id',
        'user',
        'id',
        'CASCADE');
    }

    public function down()
    {
        $this->dropIndex(
            'idx-support-id',
            'support'
        );

        $this->dropTable('support');
    }
}