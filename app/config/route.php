<?php

return [

    //URLs на контроллер Auth
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',

    //URLs на Admin module
    'admin' => 'admin/main/index',
    'admin/<action:\w+>' => 'admin/main/<action>',

    //URLs на SiteController
    '<action:\w+>' => 'site/<action>',
];