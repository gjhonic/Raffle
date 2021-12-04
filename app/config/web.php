<?php

$_ENV = array_merge($_ENV, require(__DIR__ . '/.env'));

$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';
$route = array_merge(require(__DIR__ . '/route.php'));

$basePath =  dirname(__DIR__);
$webroot = dirname($basePath);

$config = [
    'id' => 'app',
    'name' => "Raffle",
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
        'assetManager' => [
            'basePath' => '@webroot/runtime/assets',
        ],
        'user' => [
            'identityClass' => 'app\models\auth\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $_ENV['EMAIL_LOGIN'],
                'password' => $_ENV['EMAIL_PASSWORD'],
                'port' => '587',
                'encryption' => 'tls',
            ],
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
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en', 'ru', 'fr', 'de'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $route,
            'ignoreLanguageUrlPatterns' => [
                '#^admin/#' =>'#^admin/#',
                '#^api/#' =>'#^api/#',
            ],
            'enableDefaultLanguageUrlCode' => true,
            'enableLanguagePersistence' => true,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/note'  => 'note.php',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
        'api' => [
            'class' => 'app\modules\api\ApiModule',
            'modules' => [
                'open' => [
                    'class' => 'app\modules\api\modules\open\ApiOpenModule',
                ],
                'shut' => [
                    'class' => 'app\modules\api\modules\shut\ApiShutModule',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
