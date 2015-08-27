<?php
namespace frontend\modules\user\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{

    public $username;

    public $password;

    public $rememberMe = true;

    private $_user = false;

    /**
     *
     * @var \dektrium\user\Module
     */
    protected $module;

    /**
     *
     * @param Finder $finder            
     * @param array $config            
     */
    public function __construct($config = [])
    {
        $this->module = \Yii::$app->getModule('user');
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /*
         * return [
         * [['username', 'password'], 'required'],
         * ['rememberMe', 'boolean'],
         * ['password', 'validatePassword'],
         * ];
         */
        return [
            'requiredFields' => [
                [
                    'username',
                    'password'
                ],
                'required'
            ],
            'loginTrim' => [
                'username',
                'trim'
            ],
            'passwordValidate' => [
                'password',
                'validatePassword'
            ],
            'confirmationValidate' => [
                'username',
                'validatConfirmatione'
            ],
            'rememberMe' => [
                'rememberMe',
                'boolean'
            ]
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute
     *            the attribute currently being validated
     * @param array $params
     *            the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $user = $this->getUser();
            if (! $user || ! $user->validatePassword($this->password)) {
                $this->addError($attribute, '错误的账号或密码.');
            }
        }
    }

    public function validatConfirmatione($attribute, $params)
    {
        if ($this->user !== null) {
            $confirmationRequired = $this->module->enableConfirmation && ! $this->module->enableUnconfirmedLogin;
            if ($confirmationRequired && ! $this->user->getIsConfirmed()) {
                $this->addError($attribute, "用户E-MIAL尚未进行确认！");
            }
            if ($this->user->getIsBlocked()) {
                $this->addError($attribute, "账号已经被锁定！");
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名 / 邮箱',
            'password' => '密码',
            'rememberMe' => '记住我'
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        
        return $this->_user;
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'login-form';
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->getUser();
            return true;
        } else {
            return false;
        }
    }
}
