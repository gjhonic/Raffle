<?php

use yii\db\Migration;

/**
 * Class m210413_125552_user
 */
class m210413_125552_user extends Migration
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
            'password' => $this->string(255)->notNull(),
            'role_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'code' => $this->string(50)->unique()->notNull(),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(32),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-user-id',
            'user',
            'id'
        );

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
    * @inheritdoc
    */
    public function down()
    {
        $this->dropForeignKey(
            'idx-user-id',
            'user'
        );

        $this->dropIndex(
            'fk-user-role_id',
            'user'
        );

        $this->dropForeignKey(
            'fk-user-status_id',
            'user'
        );

        $this->dropTable('user');
    }
}
