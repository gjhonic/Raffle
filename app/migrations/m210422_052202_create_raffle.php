<?php

use yii\db\Migration;

/**
 * Class m210422_052202_raffle
 */
class m210422_052202_create_raffle extends Migration
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
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-raffle-id',
            'raffle',
            'id'
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

        $this->dropTable('raffle');
    }
}
