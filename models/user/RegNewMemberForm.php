<?php
namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\club\Club;

class RegNewMemberForm extends Model
{
    public $first_name;
    public $second_name;
    public $third_name;
    public $email;
    public $password;
    public $club_id;

    // Правила валидации
    public function rules()
    {
        return [
            [['first_name', 'second_name' ,'third_name' , 'email', 'password' , 'club_id'], 'required'],
            
            ['first_name' , 'trim'],
            ['second_name' , 'trim'],
            ['third_name' , 'trim'],
            ['email', 'trim'],
            ['club_id' , 'trim'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\user\User', 'message' => 'Этот email уже используется.'],
            
            ['password', 'string', 'min' => 6],

            ['club_id', 'validateClub'],
        ];
    }

    // Метод сохранения нового пользователя
    public function validateClub(){
        if (!$this->hasErrors()) {
            $club = Club::findById($this->club_id);
            if (!$club) {
                $this->addError($attribute, 'Указанный клуб не найден.');
            }
        }
    }
    
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $auth = Yii::$app->authManager;
        $user = new User();
        $user->first_name = $this->first_name;

        $user->second_name = $this->second_name;
        $user->third_name = $this->third_name;
        $user->email = $this->email;
        $user->club_id = $this->club_id;
        $user->setPassword($this->password);
        $user->generateAuthKey(); // Генерация ключа аутентификации

        $user->save();

        $auth->assign($auth->getRole('clubMember') , $user->id);
    }
}
