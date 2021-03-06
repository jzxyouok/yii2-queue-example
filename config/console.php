<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','queue','queue_chained'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.8.99',
            'port' => 6379,
            'database' => 2,
        ],
        'redis_for_queue' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.8.99',
            'port' => 6379,
            'database' => 1,
        ],
        'queue' => [
            'class' => 'zhuravljov\yii\queue\redis\Queue',
            'redis' => 'redis_for_queue', // connection ID
            'channel' => 'queue', // queue channel
        ],
        'queue_chained' => [
            'class' => 'zhuravljov\yii\queue\redis\Queue',
            'redis' => 'redis_for_queue', // connection ID
            'channel' => 'queue_chained', // queue channel
        ],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
