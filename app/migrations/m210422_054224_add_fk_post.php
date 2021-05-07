<?php

use yii\db\Migration;

/**
 * Class m210422_054224_add_fk_post
 */
class m210422_054224_add_fk_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-post-user_id',
            'post'
        );
    }
}
