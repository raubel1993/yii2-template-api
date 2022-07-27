<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
			'transport' => [
				 'class' => 'Swift_SmtpTransport',
                 'host' => 'smtp.gmail.com',
                 'username' => 'acount@gmail.com',
                 'password' => '123456',
                 'port'          => '587',
                 'encryption'    => 'tls',
                 'streamOptions' => [
                     'ssl' => [
                         'verify_peer' => true,
                         'verify_peer_name' => false,
                     ],
                 ]
			 ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
    ],
];
