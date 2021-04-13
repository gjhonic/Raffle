<?php

use yii\db\Migration;
use app\models\db\User;

/**
 * Class m210413_142301_rbac_date
 */
class m210413_142301_rbac_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        //Добавляем роль гостя
        $questRole = $auth->createRole('quest');
        $auth->add($questRole);

        //Добавляем роль юзера
        $userRole = $auth->createRole('user');
        $auth->add($userRole);
        $auth->addChild($userRole, $questRole);

        //Добавляем роль модератора
        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);
        $auth->addChild($moderatorRole, $userRole);

        //Добавляем роль админа
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $moderatorRole);

        //Добавляю рута
        $admin = new User([
            'username'        => 'root',
            'name'            => 'Евгений',
            'surname'         => 'Андреев',
            'patronymic'      => 'Андреевич',
            'role'            => 'admin',
            'password'   => '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge', // 111111
        ]);
        $admin->save();

        $auth->assign($adminRole, $admin->id);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
