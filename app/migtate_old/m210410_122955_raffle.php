<?php

use yii\db\Migration;

/**
 * Class m210410_122955_raffle
 */
class m210410_122955_raffle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('raffle', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'short_description' => $this->text(),
            'description' => $this->text(),
            'user_id' => $this->integer()->notNull(),
            'video_link' => $this->string(255),
            'image_src' => $this->string(255),
            'date_begin' => $this->string(20),
            'date_end' => $this->string(20),
            'status_id' => $this->integer()->notNull(),
            'code' => $this->string(100)->unique()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-raffle-id',
            'raffle',
            'id'
        );

        $this->addForeignKey(
            'fk-raffle-status_id',
            'raffle',
            'status_id',
            'raffle_status',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-raffle-id',
            'raffle'
        );

        $this->dropForeignKey(
            'fk-raffle-status_id',
            'raffle'
        );

        $this->dropTable('raffle');
    }
}
