<?php

use yii\db\Migration;

/**
 * Class m210422_054319_add_fk_user_other_info
 */
class m210422_054319_add_fk_user_other_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user_other_info-user_id',
            'user_other_info',
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
            'fk-user_other_info-user_id',
            'user_other_info'
        );
    }
}
