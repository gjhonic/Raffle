<?php

use yii\db\Migration;

/**
 * Class m210421_154056_user_status
 */
class m210421_154056_user_status extends Migration
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
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'idx-user_status-id',
            'user_status'
        );

        $this->dropTable('user_status');
    }
}
