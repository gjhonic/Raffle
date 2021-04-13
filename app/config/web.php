<?php

$_ENV = array_merge($_ENV, require(__DIR__ . '/.env'));

$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';

$basePath =  dirname(__DIR__);
$webroot = dirname($basePath);

$config = [
    'id' => 'app',
    'name' => "Raffle-YouTubers",
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'runtimePath' => $webroot . '/runtime',
    'vendorPath' => $webroot . '/vendor',
    'defaultRoute' => '/site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'dfwefdfk34fdldsf243',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\auth\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
