<?php

use yii\db\Migration;

/**
 * Class m210410_123622_tag_raffle
 */
class m210410_123622_raffle_tag extends Migration
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

        $this->addForeignKey(
            'fk-raffle_tag-raffle_id',
            'raffle_tag',
            'raffle_id',
            'raffle',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-raffle_tag-tag_id',
            'raffle_tag',
            'tag_id',
            'tag',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'idx-raffle_tag-raffle_id',
            'raffle_tag'
        );

        $this->dropForeignKey(
            'idx-raffle_tag-tag_id',
            'raffle_tag'
        );

        $this->dropIndex(
            'fk-raffle_tag-raffle_id',
            'raffle_tag'
        );

        $this->dropForeignKey(
            'fk-raffle_tag-tag_id',
            'raffle_tag'
        );

        $this->dropTable('raffle_tag');
    }
}
