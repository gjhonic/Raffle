<?php
use yii\helpers\Url;
use app\models\db\User;

if(Yii::$app->user->isGuest){
    return [
        'main' => [
            [
                'label' => 'Конкурсы',
                'href' => Url::to('/raffle/'),
                'controller' => 'raffle',
                'action' => 'index'
            ],
            [
                'label' => 'Войти',
                'href' => Url::to('/signin'),
                'controller' => 'auth',
                'action' => 'signin'
            ],
            [
                'label' => 'Зарегистрироваться',
                'href' => Url::to('/signup'),
                'controller' => 'auth',
                'action' => 'signup'
            ],
        ],
    ];
}else{
    if(Yii::$app->user->identity->role_id == User::ROLE_USER_ID){
        return [
            'main' => [
                [
                    'label' => 'Профиль',
                    'href' => Url::to('/profile'),
                    'controller' => 'site',
                    'action' => 'profile'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => Url::to('/raffle/'),
                    'controller' => 'raffle',
                    'action' => 'index'
                ],
                [
                    'label' => 'Создать конкурс',
                    'href' => Url::to('/raffle/create'),
                    'controller' => 'raffle',
                    'action' => 'create'
                ],
                [
                    'label' => 'Настройки',
                    'href' => Url::to('/settings/'),
                    'controller' => 'settings',
                    'action' => 'index'
                ],
                [
                    'label' => 'Выйти',
                    'href' => Url::to('/signout'),
                    'controller' => 'auth',
                    'action' => 'signout'
                ],
            ],
        ];
    }else{
        return [
            'main' => [
                [
                    'label' => 'Профиль',
                    'href' => Url::to('/profile'),
                    'controller' => 'site',
                    'action' => 'profile'
                ],
                [
                    'label' => 'Админка',
                    'href' => Url::to('/admin/'),
                    'controller' => 'admin',
                    'action' => 'asfaf'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => Url::to('/raffle/'),
                    'controller' => 'raffle',
                    'action' => 'index'
                ],
                [
                    'label' => 'Настройки',
                    'href' => Url::to('/settings/'),
                    'controller' => 'settings',
                    'action' => 'index'
                ],
                [
                    'label' => 'Выйти',
                    'href' => Url::to('/signout'),
                    'controller' => 'auth',
                    'action' => 'signout'
                ],
            ],
        ];
    }
}

