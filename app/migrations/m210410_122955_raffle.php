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
            'author_id' => $this->integer(),
            'link' => $this->string(255),
            'date_begin' => $this->string(100),
            'date_end' => $this->string(100),
            'conditions' => $this->integer(),
            'tags' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('raffle');
    }
}
