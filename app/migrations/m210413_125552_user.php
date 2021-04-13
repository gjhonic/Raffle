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
            'username' => $this->string(255),
            'name' => $this->string(50),
            'surname' => $this->string(50),
            'patronymic' => $this->string(50),
            'role' => $this->string(50),
            'password' => $this->string(255),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(32),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
