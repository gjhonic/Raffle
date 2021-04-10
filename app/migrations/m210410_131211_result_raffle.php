<?php

use yii\db\Migration;

/**
 * Class m210410_131211_result_raffle
 */
class m210410_131211_result_raffle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('result_raffle', [
            'id' => $this->primaryKey(),
            'raffle_id' => $this->integer(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('result_raffle');
    }
}
