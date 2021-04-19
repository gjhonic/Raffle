<?php

use yii\helpers\Url;

return [
    [
        'label' => 'Главная',
        'href' => URL::to('admin'),
    ],
    [
        'label' => 'Пользователи',
        'href' => URL::to('admin/user/'),
    ],
];