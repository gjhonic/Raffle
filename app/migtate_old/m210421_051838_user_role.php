<?php

use yii\db\Migration;

/**
 * Class m210421_051838_user_role
 */
class m210421_051838_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_role', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->unique()->notNull(),
            'description' => $this->text(),
        ]);

        $this->createIndex(
            'idx-user_role-id',
            'user_role',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'idx-user_role-id',
            'user_role'
        );

        $this->dropTable('user_role');
    }
}
