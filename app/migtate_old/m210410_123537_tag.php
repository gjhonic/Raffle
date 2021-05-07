<?php

use yii\db\Migration;

/**
 * Class m210410_123537_tag
 */
class m210410_123537_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->unique()->notNull(),
        ]);

        $this->createIndex(
            'idx-tag-id',
            'tag',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'idx-tag-id',
            'tag'
        );

        $this->dropTable('tag');
    }
}
