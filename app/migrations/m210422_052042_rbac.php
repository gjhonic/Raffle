<?php

use yii\db\Migration;

/**
 * Class m210422_052042_rbac
 */
class m210422_052042_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->runAction('migrate', [
            'migrationPath' => '@yii/rbac/migrations',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        Yii::$app->runAction('migrate/down', [
            'migrationPath' => '@yii/rbac/migrations',
        ]);
    }
}
