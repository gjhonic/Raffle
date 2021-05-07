<?php

use yii\db\Migration;

/**
 * Class m210421_154233_post
 */
class m210421_154233_post extends Migration
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

        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'idx-post-id',
            'post'
        );

        $this->dropIndex(
            'fk-post-user_id',
            'post'
        );

        $this->dropTable('post');
    }
}
