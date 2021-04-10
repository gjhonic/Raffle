<?php

use yii\db\Migration;

/**
 * Class m210410_123622_tag_raffle
 */
class m210410_123622_tag_raffle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_raffle', [
            'id' => $this->primaryKey(),
            'raffle_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag_raffle');
    }
}
