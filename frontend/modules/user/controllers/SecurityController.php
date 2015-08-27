<?php
namespace frontend\modules\user\controllers;

use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\traits\AjaxValidationTrait;

class SecurityController extends Controller
{
    use AjaxValidationTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'login',
                            'auth'
                        ],
                        'roles' => [
                            '?'
                        ]
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'login',
                            'auth',
                            'logout'
                        ],
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['logout' => ['post']]
            ]
            
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::className(),
                // if user is not logged in, will try to log him in, otherwise
                // will try to connect social account to user.
                'successCallback' => \Yii::$app->user->isGuest ? [
                    $this,
                    'authenticate'
                ] : [
                    $this,
                    'connect'
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 显示登录页面.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        
        if (! \Yii::$app->user->isGuest) {
            $this->redirect(Url::to([
                '/user'
            ]));
        }
        
        $model = \Yii::createObject(LoginForm::className());
        
        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->getRequest()
            ->post()) && $model->login()) {
            return $this->goBack();
        }
        
        return $this->render('login', [
            'model' => $model,
            'module' => $this->module
        ]);
    }

    /**
     * 用户登出并跳转到首页.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        //return $this->goHome();
        return $this->redirect(Url::to([
                '/user/security/login'
            ]));
    }

    /**
     * Tries to authenticate user via social network.
     * If user has alredy used
     * this network's account, he will be logged in. Otherwise, it will try
     * to create new user account.
     *
     * @param ClientInterface $client            
     */
    public function authenticate(ClientInterface $client)
    {
        $account = forward_static_call([
            $this->module->modelMap['Account'],
            'createFromClient'
        ], $client);
        
        if (null === ($user = $account->user)) {
            $this->action->successUrl = Url::to([
                '/user/registration/connect',
                'account_id' => $account->id
            ]);
        } else {
            Yii::$app->user->login($user, $this->module->rememberFor);
        }
    }

    /**
     * 尝试连接第三方登录账户
     *
     * @param ClientInterface $client            
     */
    public function connect(ClientInterface $client)
    {
        forward_static_call([
            $this->module->modelMap['Account'],
            'connectWithUser'
        ], $client);
        $this->action->successUrl = Url::to([
            '/user/settings/networks'
        ]);
    }
}