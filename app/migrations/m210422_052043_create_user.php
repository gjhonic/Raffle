<?php

use yii\db\Migration;

/**
 * Class m210422_052043_user
 */
class m210422_052043_create_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'surname' => $this->string(50)->notNull(),
            'username' => $this->string(255)->unique()->notNull(),
            'email' => $this->string(50)->unique()->notNull(),
            'email_confirm' => $this->integer(1)->notNull(),
            'password' => $this->string(255)->notNull(),
            'role_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'code' => $this->string(50)->unique()->notNull(),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(32),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user-id',
            'user',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-user-id',
            'user'
        );

        $this->dropTable('user');
    }
}
