<?php

use yii\db\Migration;

/**
 * Class m210422_052125_user_other_info
 */
class m210422_052125_create_user_other_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_other_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'atr_id' => $this->integer()->notNull(),
            'value' => $this->text(),
        ]);

        $this->createIndex(
            'idx-user_other_info-id',
            'user_other_info',
            'id'
        );

        $this->createIndex(
            'idx-user_other_info-user_id',
            'user_other_info',
            'user_id'
        );

        $this->createIndex(
            'idx-user_other_info-atr_id',
            'user_other_info',
            'atr_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-user_other_info-id',
            'user_other_info'
        );

        $this->dropIndex(
            'idx-user_other_info-user_id',
            'user_other_info'
        );

        $this->dropIndex(
            'idx-user_other_info-atr_id',
            'user_other_info'
        );

        $this->dropTable('user_other_info');
    }
}
