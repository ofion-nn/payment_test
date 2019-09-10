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
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // Компонент подключения к БД или его конфиг
            'tableName' => '{{%queue}}', // Имя таблицы
            'channel' => 'default', // Выбранный для очереди канал
            'mutex' => \yii\mutex\MysqlMutex::class, // Мьютекс для синхронизации запросов
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                '<controller:[a-z\-_]+>/<action:[a-z\-_]+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
