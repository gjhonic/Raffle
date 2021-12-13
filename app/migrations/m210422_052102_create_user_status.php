<?php

use yii\db\Migration;
use app\models\base\UserStatus;

/**
 * Class m210422_052102_user_status
 */
class m210422_052102_create_user_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_status', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->unique()->notNull(),
        ]);

        $this->createIndex(
            'idx-user_status-id',
            'user_status',
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
            'idx-user_status-id',
            'user_status'
        );

        $this->dropTable('user_status');
    }

    /**
     * Метод добавляет в БД статусы
     */
    private function addDataToDB()
    {
        $active = new UserStatus();
        $active->title = "active";
        $active->save();

        $tag_on_ban = new UserStatus();
        $tag_on_ban->title = "tag on ban";
        $tag_on_ban->save();

        $ban = new UserStatus();
        $ban->title = "ban";
        $ban->save();
    }
}
