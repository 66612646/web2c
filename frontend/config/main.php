<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
/*          'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ], */
         'user' =>  [      // Webuser for the frontend
            'class'             => '\yii\web\User',
            'loginUrl'          => array('/account/login'),
            'enableAutoLogin' => true,
            'identityClass'     => 'frontend\modules\account\models\user',
            'idParam'           => '_mId',
            'identityCookie'    => ['name'=>'_ff','httpOnly' => true],
        ],
        'adminUser' => array(   // Webuser for the admin area (admin)
            'class'             => '\yii\web\User',
            'loginUrl'          => array('/admin/login/'),
            'enableAutoLogin' => true,
            'identityClass'     => 'frontend\modules\acconut\models\admin',
            'idParam'           => '_aId',
            'identityCookie'    => ['name'=>'_aa','httpOnly' => true],
        ),
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'frontend\modules\user\clients\QqOAuth',
                    'clientId'=>'your_qq_clientid',
                    'clientSecret'=>'your_qq_secret'
                ],
            ],
        ],
        'assetManager' => [
            'forceCopy' => YII_DEBUG
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => "",
            'rules' => [ '' => 'site/index', // 如果没有这里，则访问域名不能直接打开默认Action
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
    ],
    'modules' => [
	    'account' => [
	    	'class' => 'frontend\modules\account\Module',
	    ],
        'home' => [
            'class' => 'frontend\modules\home\Module',
        ],
    ],
    'params' => $params,
];
