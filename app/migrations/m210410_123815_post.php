<?php

use yii\db\Migration;

/**
 * Class m210410_123815_post
 */
class m210410_123815_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'description' => $this->integer(),
            'author_id' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}  
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
