<?php

// comment out the following two lines when deployed to production
require(__DIR__ . '/../.env');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require(__DIR__ . '/../app/config/web.php');

(new yii\web\Application($config))->run();
