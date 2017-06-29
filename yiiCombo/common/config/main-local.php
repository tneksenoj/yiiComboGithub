<?php
use common\config\yiicfg;

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => yiicfg::DB_connect,
            'username' => yiicfg::DB_username,
            'password' => yiicfg::DB_password,
            'charset' => 'utf8',
        ],
        'ocdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => yiicfg::OCDB_connect,
            'username' => yiicfg::OCDB_username,
            'password' => yiicfg::OCDB_password,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
            	'class' => 'Swift_SmtpTransport',
            	'host' => 'localhost',
            	'username' => 'mailer@www.sharebio.org',
            	'password' => 'z3Brah5likeBIOLOGY',
            	'port' => '25',
            	'encryption' => 'tls',
             ],
        ],
    ],
];
