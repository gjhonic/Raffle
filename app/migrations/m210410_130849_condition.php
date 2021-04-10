<?php

use yii\db\Migration;

/**
 * Class m210410_130849_condition
 */
class m210410_130849_condition extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('condition', [
            'id' => $this->primaryKey(),
            'raffle_id' => $this->integer(),
            'title' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('condition');
    }
}
