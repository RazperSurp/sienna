<?php
namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\user\User;

class ChangePasswordForm extends Model
{
    public $userId;
    public $newPassword;

    public function rules()
    {
        return [
            [['newPassword', 'userId'], 'required'],

            ['newPassword', 'string', 'min' => 6],

            ['newPassword', 'validateNewPassword'],
        ];
    }


    public function validateUser($attribute){
        if(!$this->hasErrors()){
            if(!User::findIdentity($this->userId)) $this->addError($attribute, 'Такого пользователя не сущесвует');
        }
    }

    public function validateNewPassword($attribute){
        if(!$this->hasErrors()){
            $user = User::findIdentity()
            if (Yii::$app->user->identity->validatePassword($this->newPassword)) {
                $this->addError($attribute, 'Новый пароль не может совпадать со старым');
            }
        }
    }

    public function changePassword(){
        if(!$this->validate()) return false;
        $user = Yii::$app->user->identity;
        $user->setPassword($this->newPassword);
        return $user->save();
    }
}