<?php
namespace frontend\modules\account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\modules\account\models\LoginForm;
use frontend\modules\account\traits\AjaxValidationTrait;

class LoginController extends Controller
{
    use AjaxValidationTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'auth'
                        ],
                        'roles' => [
                            '?'
                        ]
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        if (! \Yii::$app->user->isGuest) {
            $this->redirect(Url::to([
                '/home'
            ]));
        }
        
        $model = \Yii::createObject(LoginForm::className());
        
        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->getRequest()
            ->post()) && $model->login()) {
            return $this->redirect(Url::to([
                '/home'
            ]));
        }
        
        return $this->render('index', [
            'model' => $model,
            'module' => $this->module
        ]);
    }
}