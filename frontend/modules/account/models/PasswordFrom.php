<?php
namespace frontend\modules\account\models;

use yii\base\Model;
use yii\base\NotSupportedException;

class PasswordForm extends Model
{
    /** @var string */
    public $new_password;

    /** @var string */
    public $current_password;

    /** @var Module */
    protected $module;

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = \Yii::$app->user->identity;
        }

        return $this->_user;
    }

    /** @inheritdoc */
    public function __construct($config = [])
    {
        $this->module = \Yii::$app->getModule('user');
        parent::__construct($config);
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            'newPasswordLength' => ['new_password', 'string', 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => ['current_password', function ($attr) {
                if (!Yii::$app->getSecurity()->validatePassword($this->$attr, $this->user->password_hash)) {
                    $this->addError($attr, \Yii::t('user', 'Current password is not valid'));
                }
            }]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'new_password'     => \Yii::t('user', 'New password'),
            'current_password' => \Yii::t('user', 'Current password')
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'password-form';
    }

    /**
     * Saves new password setting.
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $this->user->scenario = 'settings';
            $this->user->password = $this->new_password;
            return $this->user->save();
        }

        return false;
    }

}
