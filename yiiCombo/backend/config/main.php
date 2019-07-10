<?php
use common\config\yiicfg;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
          'admin' => [
              'class' => 'mdm\admin\Module',
              'layout' => 'left-menu',
              ],
      ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
              'name' => '_backendUser',
              'path' => '/backend/web',
            ],
        ],
        'session' => [
            'name' => '_backendSessionId',
            'savePath' => __DIR__ . '/../runtime',
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
        'authManager' => [
                'class' => 'yii\rbac\DbManager',
                //'defaultRoles' => ['guest'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'webdavFs' => [
            'class' => 'creocoder\flysystem\WebDAVFilesystem',
            'baseUri' => yiicfg::WebDav,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
              //'<controller:(Requests)>/<action:(AddToOC)>/<username:\w+>/<projectname\w+>' => '<controller>/<action>',
              '<controller:(requests)>/<username:\w+>/<projectname:\w+>' => 'requests/addtooc',
            //'Requests/AddToOC/<username:\w+>/<projectname:\w+>' => 'requests/index',
            //'requests/<username:\w+>/<projectname:\w+>' => 'requests/AddToOC',
            //'requests' => 'requests/AddToOC',
            //'requests/<username:\w+>' => 'requests/AddToOC',
          ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
        ],
    ],


    /*'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'projects/*',
            //'admin/*',
            //'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],*/
    'params' => [
        'icon-framework' => 'fa',  // Font Awesome Icon framework
    ],
];