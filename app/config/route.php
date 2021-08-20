<?php

return [

    //URLs на контроллер Auth
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',
    'search' => 'site/search',
    'raffle-by-tag/<tag>' => 'raffle/raffle-by-tag',
    'confirm-email' => 'auth/confirm-email',
    'return-confirm-email' => 'auth/return-confirm-email',

    //URLs на Admin module
    'admin' => 'admin/main/index',
    'admin/<action:\w+>' => 'admin/main/<action>',

    //URLs на Api module
    'api' => 'api/open/main/index',
    'api/shut/<action:\w+>' => 'api/shut/main/<action>', // На закрытый api - для системы, бота
    'api/shut/<controller:\w+>/<action:\w+>' => 'api/shut/<controller>/<action>',
    'api/<controller:\w+>/<action:\w+>' => 'api/open/<controller>/<action>', // На публичный api

    //URLs на SiteController
    'profile/<code>' => 'site/profile',
    'show/<code>' => 'raffle/view',
    'raffle/update/<code>' => 'raffle/update',
    'raffle/list/<code>' => 'raffle/list',
    '<action:\w+>' => 'site/<action>',
];