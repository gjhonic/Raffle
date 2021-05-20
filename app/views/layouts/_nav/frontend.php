<?php
use yii\helpers\Url;
use app\models\db\User;

if(Yii::$app->user->isGuest){
    return [
        'main' => [
            [
                'label' => 'Конкурсы',
                'href' => URL::to('/raffle/'),
                'controller' => 'raffle'
            ],
            [
                'label' => 'Войти',
                'href' => URL::to('/signin'),
                'controller' => 'auth'
            ],
            [
                'label' => 'Зарегистрироваться',
                'href' => URL::to('/signup'),
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
                    'href' => URL::to('/profile'),
                    'controller' => 'site'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => URL::to('/raffle/'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Добавить конкурс',
                    'href' => URL::to('/raffle/create'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Настройки',
                    'href' => URL::to('/settings/'),
                    'controller' => 'settings'
                ],
                [
                    'label' => 'Выйти',
                    'href' => URL::to('/signout'),
                    'controller' => 'auth'
                ],
            ],
        ];
    }else{
        return [
            'main' => [
                [
                    'label' => 'Профиль',
                    'href' => URL::to('/profile'),
                    'controller' => 'site'
                ],
                [
                    'label' => 'Админка',
                    'href' => URL::to('/admin/'),
                    'controller' => 'admin'
                ],
                [
                    'label' => 'Конкурсы',
                    'href' => URL::to('/raffle/'),
                    'controller' => 'raffle'
                ],
                [
                    'label' => 'Настройки',
                    'href' => URL::to('/settings/'),
                    'controller' => 'settings'
                ],
                [
                    'label' => 'Выйти',
                    'href' => URL::to('/signout'),
                    'controller' => 'auth'
                ],
            ],
        ];
    }
}

