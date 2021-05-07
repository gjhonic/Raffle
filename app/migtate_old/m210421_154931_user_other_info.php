<?php

use yii\db\Migration;

/**
 * Class m210421_154931_user_other_info
 */
class m210421_154931_user_other_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_other_info', [
            'user_id' => $this->integer()->notNull(),
            'atr_id' => $this->integer()->notNull(),
            'value' => $this->text(),
        ]);

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

        $this->addForeignKey(
            'fk-user_other_info-user_id',
            'user_other_info',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-user_other_info-atr_id',
            'user_other_info',
            'atr_id',
            'user_attribute',
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
            'idx-user_other_info-user_id',
            'user_other_info'
        );

        $this->dropForeignKey(
            'idx-user_other_info-atr_id',
            'user_other_info'
        );

        $this->dropIndex(
            'fk-user_other_info-user_id',
            'user_other_info'
        );

        $this->dropForeignKey(
            'fk-user_other_info-atr_id',
            'user_other_info'
        );

        $this->dropTable('user_other_info');
    }
}
