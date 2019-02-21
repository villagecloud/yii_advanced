<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain'=>'.yii2'],

        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced',
            //'savePath'=> __DIR__ . '/../../sessions'
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

            'rules' => [
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'taskapi', 'pluralize' => false]
/*                'GET messages' => 'task-api/index',
                'POST message' => 'task-api/create',
                'GET message/<id>' => 'task-api/view',
                'PATCH message/<id>' => 'task-api/update',
                'DELETE message/<id>' => 'task-api/delete',*/
            ],
        ],

    ],
    'params' => $params,
];
