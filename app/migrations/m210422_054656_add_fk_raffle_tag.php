<?php

use yii\db\Migration;

/**
 * Class m210422_054656_add_fk_raffle_tag
 */
class m210422_054656_add_fk_raffle_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
            'fk-raffle_tag-raffle_id',
            'raffle_tag'
        );

        $this->dropForeignKey(
            'fk-raffle_tag-tag_id',
            'raffle_tag'
        );
    }
}
