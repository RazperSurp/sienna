<?php
namespace app\models\admin;

use Yii;
use yii\base\Model;
use app\models\user\User;

class ChangePassword extends Model
{
    public $userId;
    public $newPassword;

    /**
     * @var User|null Кешированный объект пользователя, чтобы не делать повторные запросы в БД
     */
    private $_user;

    public function rules()
    {
        return [
            [['userId', 'newPassword'], 'required'],
            ['userId', 'integer'], 
            ['userId', 'validateUser'],
            ['newPassword', 'string', 'min' => 6],
            ['newPassword', 'validateNewPassword'],
        ];
    }

    public function validateUser($attribute)
    {
        if (!$this->hasErrors()) {
            if (!$this->getUser()) {
                $this->addError($attribute, 'Такого пользователя не существует.');
            }
        }
    }

    public function validateNewPassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->validatePassword($this->newPassword)) {
                $this->addError($attribute, 'Новый пароль не может совпадать со старым.');
            }
        }
    }

    public function changePassword()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = $this->getUser();
        if ($user) {
            $user->setPassword($this->newPassword);
            //сбрасывать auth_key при смене пароля, чтобы разлогинить пользователя на других устройствах
            if ($user->hasMethod('generateAuthKey')) {
                $user->generateAuthKey();
            }
            return (bool)$user->save();
        }
        
        return false;
    }

    /**
     * Получение объекта пользователя с кешированием внутри модели
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentity($this->userId);
        }
        return $this->_user;
    }
}
