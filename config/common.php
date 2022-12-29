<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            //'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => $params['DB_DSN'],
            'username' => $params['DB_USER'],
            'password' => $params['DB_PASS'],
            'charset' => 'utf8',

            'enableSchemaCache' => $params['DB_CACHE'],
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\symfonymailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtps',
                'host' => $params['EMAIL_HOST'],
                'username' => $params['EMAIL_USER'],
                'password' => $params['EMAIL_PASS'],
                'port'          => $params['EMAIL_PORT'],
                'encryption'    => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => true,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
    ],
];
