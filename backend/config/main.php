<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'common\models\User',
                'accessRoles' => ['admin']
            ]
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '//heikki.tmweb.ru',
            'rules' => [
                '/' => 'site/index',
                //'<action:(login|logout|auth|authback|changepass|resetpass|sendpass|telegramset|telegramhook)>' => 'site/<action>',

                '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w-]+>' => '<controller>/index',

                //'<action:[\w-]+>' => 'site/<action>',
                '<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',


                '<module:[\w-]+>/<controler:[\w-]+>/<id:\d+>' => '<module>/<controller>/index',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>'

            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
