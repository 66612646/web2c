<?php
namespace  frontend\modules\user\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\SettingsForm;

/**
 * SettingsController 设置用户信息 (e.g. profile, email and password).
 */
class SettingsController extends Controller
{
    
    /** @inheritdoc */
    public $defaultAction = 'profile';

    /**
     * @param string $id
     * @param \yii\base\Module $module
     * @param Finder $finder
     * @param array $config
     */

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'confirm', 'networks', 'disconnect'],
                        'roles'   => ['@']
                    ],
                ]
            ],
        ];
    }

    /**
     * 显示设置用户个人信息项.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Displays page where user can update account settings (username, email or password).
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /**
     * Attempts changing user's password.
     * @param  integer $id
     * @param  string  $code
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->emailChangeStrategy == Module::STRATEGY_INSECURE) {
            throw new NotFoundHttpException;
        }

        $user->attemptEmailChange($code);

        return $this->redirect(['account']);
    }

    /**
     * Displays list of connected network accounts.
     * @return string
     */
    public function actionNetworks()
    {
        return $this->render('networks', [
            'user' => \Yii::$app->user->identity
        ]);
    }

    /**
     * Disconnects a network account from user.
     * @param  integer $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDisconnect($id)
    {
        $account = $this->finder->findAccountById($id);
        if ($account === null) {
            throw new NotFoundHttpException;
        }
        if ($account->user_id != \Yii::$app->user->id) {
            throw new ForbiddenHttpException;
        }
        $account->delete();

        return $this->redirect(['networks']);
    }
}
