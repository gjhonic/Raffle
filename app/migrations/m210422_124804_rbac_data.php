<?php

use yii\db\Migration;
use app\models\db\User;

/**
 * Class m210422_124804_rbac_data
 */
class m210422_124804_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        //Добавляем роль юзера
        $userRole = $auth->createRole('user');
        $auth->add($userRole);

        //Добавляем роль модератора
        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);
        $auth->addChild($moderatorRole, $userRole);

        //Добавляем роль админа
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $moderatorRole);

        //Добавляю рута
        $user = new User();
        $user->name = "Админ";
        $user->surname = "Админов";
        $user->username = "admin";
        $user->email = "admin@raffle.com";
        $user->password = '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge'; // 111111
        $user->code = "admin1001";
        $user->role_id = 1;
        $user->status_id = 1;
        $user->email_confirm = 1;
        $user->save();

        $auth->assign($adminRole, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
