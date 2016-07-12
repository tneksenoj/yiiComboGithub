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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
