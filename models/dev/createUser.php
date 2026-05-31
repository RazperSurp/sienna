<?php
namespace app\models\dev;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\club\Club;

class createUser extends Model
{
    public $first_name;
    public $second_name;
    public $third_name;
    public $email;
    public $password;
    public $role;
    public $club;

    // Правила валидации
    public function rules()
    {
        return [
            [['first_name', 'second_name' ,'third_name' , 'email', 'password' , 'role'], 'required'],
            
            ['first_name' , 'trim'],
            ['second_name' , 'trim'],
            ['third_name' , 'trim'],
            ['email', 'trim'],
            ['club' , 'trim'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\user\User', 'message' => 'Этот email уже используется.'],
            
            ['password', 'string', 'min' => 6],

            ['club', 'validateClub'],

            ['role', 'validateRole'],
        ];
    }

    // Метод сохранения нового пользователя
    public function validateClub($attribute , $params){
        if (!$this->hasErrors()) {
            $club = Club::findByName($this->club);
            if (!$club) {
                $this->addError($attribute, 'Указанный клуб не найден.');
            }
        }
    }

    public function validateRole($attribute , $params){
        if (!$this->hasErrors()) {
            $role = Yii::$app->authManager->getRole($this->role);
            if (!$role) {
                $this->addError($attribute, 'Такой роли не сущесвует.');
            }
        }
    }

    
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->role);
        $user = new User();
        $user->first_name = $this->first_name;
        $user->second_name = $this->second_name;
        $user->third_name = $this->third_name;
        $user->email = $this->email;
        $club = $this->club ? Club::findByName($this->club) : null;
        $user->club_id = $club ? $club->id : null;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save();

        $auth->assign($role , $user->id);
    }
}
