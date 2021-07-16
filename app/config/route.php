<?php

return [

    //URLs на контроллер Auth
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',
    'search' => 'site/search',
    'confirm-email' => 'auth/confirm-email',
    'return-confirm-email' => 'auth/return-confirm-email',

    //URLs на Admin module
    'admin' => 'admin/main/index',
    'admin/<action:\w+>' => 'admin/main/<action>',

    //URLs на Api module
    'api' => 'api/main/index',
    'api/<action:\w+>' => 'admin/main/<action>',

    //URLs на SiteController
    'profile/<code>' => 'site/profile',
    'show/<code>' => 'raffle/view',
    'raffle/update/<code>' => 'raffle/update',
    'raffle/list/<code>' => 'raffle/list',
    '<action:\w+>' => 'site/<action>',
];