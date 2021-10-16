<?php
use yii\helpers\Url;
use app\models\db\User;

if(Yii::$app->user->isGuest){
    return [
        'main' => [
            [
                'label' => 'Конкурсы',
                'href' => Url::to('/raffle/'),
                'controller' => 'raffle'
            ],
            [
                'label' => 'Войти',
                'href' => Url::to('/signin'),
                'controller' => 'auth'
            ],
            [
                'label' => 'Зарегистрироваться',
                'href' => Url::to('/signup'),
                'controller' => 'auth'
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
                    'controller' => 'site'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => Url::to('/raffle/'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Создать конкурс',
                    'href' => Url::to('/raffle/create'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Настройки',
                    'href' => Url::to('/settings/'),
                    'controller' => 'settings'
                ],
                [
                    'label' => 'Выйти',
                    'href' => Url::to('/signout'),
                    'controller' => 'auth'
                ],
            ],
        ];
    }else{
        return [
            'main' => [
                [
                    'label' => 'Профиль',
                    'href' => Url::to('/profile'),
                    'controller' => 'site'
                ],
                [
                    'label' => 'Админка',
                    'href' => Url::to('/admin/'),
                    'controller' => 'admin'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => Url::to('/raffle/'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Настройки',
                    'href' => Url::to('/settings/'),
                    'controller' => 'settings'
                ],
                [
                    'label' => 'Выйти',
                    'href' => Url::to('/signout'),
                    'controller' => 'auth'
                ],
            ],
        ];
    }
}

