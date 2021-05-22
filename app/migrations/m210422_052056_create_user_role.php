<?php

use yii\db\Migration;
use app\models\db\UserRole;

/**
 * Class m210422_052056_user_role
 */
class m210422_052056_create_user_role extends Migration
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

        $this->addDataToDB();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-user_role-id',
            'user_role'
        );

        $this->dropTable('user_role');
    }

    /**
     * Метод добавляет в БД роли
     */
    private function addDataToDB()
    {
        $admin = new UserRole();
        $admin->title = 'admin';
        $admin->save();

        $moderator = new UserRole();
        $moderator->title = 'moderator';
        $moderator->save();

        $user = new UserRole();
        $user->title = 'user';
        $user->save();
    }
}
