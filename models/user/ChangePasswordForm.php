<?php
namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\user\User;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;

    public function rules()
    {
        return [
            [['newPassword', 'oldPassword'], 'required'],

            ['newPassword', 'string', 'min' => 6],

            ['oldPassword', 'validateOldPassword'],
            ['newPassword', 'validateNewPassword'],
        ];
    }

    public function validateOldPassword($attribute){
        if(!$this->hasErrors()){
            if (!Yii::$app->user->identity->validatePassword($this->oldPassword)) {
                $this->addError($attribute, 'Неправильный пароль');
            }
        }
    }

    public function validateNewPassword($attribute){
        if(!$this->hasErrors()){
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