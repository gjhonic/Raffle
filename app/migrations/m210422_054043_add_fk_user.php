<?php

use yii\db\Migration;

/**
 * Class m210422_054043_add_fk_user
 */
class m210422_054043_add_fk_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-role_id',
            'user',
            'role_id',
            'user_role',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-user-status_id',
            'user',
            'status_id',
            'user_status',
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
            'fk-user-role_id',
            'user'
        );

        $this->dropForeignKey(
            'fk-user-status_id',
            'user'
        );
    }

}
