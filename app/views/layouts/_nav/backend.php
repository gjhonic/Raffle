<?php

use yii\helpers\Url;

return [
    'main' => [
        [
            'label' => 'Главная',
            'href' => URL::to('/admin'),
            'controller' => 'main'
        ],
        [
            'label' => 'На сайт',
            'href' => URL::to('/'),
            'controller' => 'site'
        ],
    ],
    'bases' => [
        [
            'label' => 'Пользователи',
            'href' => URL::to('/admin/user/'),
            'controller' => 'user'
        ],
        [
            'label' => 'Конкурсы',
            'href' => URL::to('/admin/raffle/'),
            'controller' => 'raffle'
        ],
        [
            'label' => 'Теги',
            'href' => URL::to('/admin/tag/'),
            'controller' => 'tag'
        ],
    ],
    'moderations' => [
        [
            'label' => 'Пользователи',
            'href' => URL::to('/admin/user-mod/'),
            'controller' => 'user-mod'
        ],
        [
            'label' => 'Конкурсы',
            'href' => URL::to('/admin/raffle-mod/'),
            'controller' => 'raffle-mod'
        ],
        [
            'label' => 'Обращения',
            'href' => URL::to('/admin/support-mod/'),
            'controller' => 'support-mod'
        ],
    ],
    'other' => [
        [
            'label' => 'Private API',
            'href' => URL::to('/api/shut'),
            'controller' => 'site'
        ],
        [
            'label' => 'Public API',
            'href' => URL::to('/api'),
            'controller' => 'site'
        ]
    ]
];