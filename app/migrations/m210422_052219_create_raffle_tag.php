<?php

use yii\db\Migration;

/**
 * Class m210422_052219_raffle_tag
 */
class m210422_052219_create_raffle_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('raffle_tag', [
            'raffle_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-raffle_tag-raffle_id',
            'raffle_tag',
            'raffle_id'
        );

        $this->createIndex(
            'idx-raffle_tag-tag_id',
            'raffle_tag',
            'tag_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-raffle_tag-raffle_id',
            'raffle_tag'
        );

        $this->dropIndex(
            'idx-raffle_tag-tag_id',
            'raffle_tag'
        );

        $this->dropTable('raffle_tag');
    }
}
