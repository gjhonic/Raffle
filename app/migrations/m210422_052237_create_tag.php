<?php

use yii\db\Migration;

/**
 * Class m210422_052237_tag
 */
class m210422_052237_create_tag extends Migration
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
        $this->dropIndex(
            'idx-tag-id',
            'tag'
        );

        $this->dropTable('tag');
    }
}
