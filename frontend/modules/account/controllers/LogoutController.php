<?php
namespace frontend\modules\account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class LogoutController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}