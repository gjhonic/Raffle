<?php

use yii\db\Migration;

/**
 * Class m210422_052147_post
 */
class m210422_052147_create_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'description' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-post-id',
            'post',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-post-id',
            'post'
        );

        $this->dropTable('post');
    }
}
