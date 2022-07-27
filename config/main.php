<?php

$aliases = require __DIR__ . '/aliases.php';
$rules = require __DIR__ . '/rules.php';
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => $aliases,
    'modules' => [
        'common' => [
            'class' => 'common\Module',
        ],
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ],
            'enableCsrfValidation'   => false,
			'enableCookieValidation' => false,
        ],
		'response' => [
            'class' => 'yii\web\Response',
            'format' => yii\web\Response::FORMAT_JSON,
            /*'on beforeSend' => function ($event) {
                $controlador = explode('/', Yii::$app->requestedRoute);
                if ($controlador && in_array($controlador[0], ['gii', 'debug'])) {
                    Yii::$app->getResponse()->format = yii\web\Response::FORMAT_HTML;
                    return;
                }
            },*/
            'charset' => 'UTF-8',
        ], 
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => false,
            'enableSession' => false,
        ],
        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $rules,
        ],
    ],
    'as PurifierBehaviors' =>  \common\behaviors\PurifierBehaviors::class,
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'as GiiBehaviors' => \rguerral\gii\GiiBehaviors::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}



return $config;
