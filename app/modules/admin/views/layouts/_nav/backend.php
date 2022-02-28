<?php

use yii\helpers\Url;

return [
    'main' => [
        [
            'label' => 'Главная',
            'href' => Url::to('/admin'),
            'controller' => 'main'
        ],
        [
            'label' => 'На сайт',
            'href' => Url::to('/'),
            'controller' => 'site'
        ],
    ],
    'bases' => [
        [
            'label' => 'Пользователи',
            'href' => Url::to('/admin/user/'),
            'controller' => 'user'
        ],
        [
            'label' => 'Конкурсы',
            'href' => Url::to('/admin/raffle/'),
            'controller' => 'raffle'
        ],
        [
            'label' => 'Теги',
            'href' => Url::to('/admin/tag/'),
            'controller' => 'tag'
        ],
        [
            'label' => 'IP адреса',
            'href' => Url::to('/admin/address/'),
            'controller' => 'address'
        ],
        [
            'label' => 'Action cron',
            'href' => Url::to('/admin/action-cron/'),
            'controller' => 'action-cron'
        ],
    ],
    'moderations' => [
        [
            'label' => 'Пользователи',
            'href' => Url::to('/admin/user-mod/'),
            'controller' => 'user-mod'
        ],
        [
            'label' => 'Конкурсы',
            'href' => Url::to('/admin/raffle-mod/'),
            'controller' => 'raffle-mod'
        ],
        [
            'label' => 'Обращения',
            'href' => Url::to('/admin/support-mod/'),
            'controller' => 'support-mod'
        ],
    ]
];