<?php
use yii\helpers\Url;
use app\models\db\User;

if(Yii::$app->user->isGuest){
    return [
        'main' => [
            [
                'label' => 'Войти',
                'href' => URL::to('/signin'),
                'controller' => 'auth'
            ],
            [
                'label' => 'Конкурсы',
                'href' => URL::to('/raffle/'),
                'controller' => 'raffle'
            ],
        ],
    ];
}else{
    if(Yii::$app->user->identity->getRole()->title == User::ROLE_USER){
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
                    'label' => 'Выйти',
                    'href' => URL::to('/signout'),
                    'controller' => 'auth'
                ],
            ],
        ];
    }
}

