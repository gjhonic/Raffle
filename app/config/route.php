<?php

return [

    //URLs на контроллер Auth
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',
    'confirm-email' => 'auth/confirm-email',
    'mail' => 'auth/mail',

    //URLs на Admin module
    'admin' => 'admin/main/index',
    'admin/<action:\w+>' => 'admin/main/<action>',

    //URLs на SiteController
    'profile/<code>' => 'site/profile',
    '<action:\w+>' => 'site/<action>',


];