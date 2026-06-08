<?php
namespace app\models\club;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\club\Club;

class NewClubForm extends Model
{
    public $name;
    public $president_user_id;


    // Правила валидации
    public function rules()
    {
        return [
            [['name' , 'president_user_id'], 'required'],
            
            ['name' , 'trim'],
            ['name', 'unique', 'targetClass' => '\app\models\club\Club', 'message' => 'Это имя уже используется.'],
            ['name', 'string'],

            ['president_user_id' , 'integer'],
            ['president_user_id' , 'validatePresident'],
        ];
    }

    public function validatePresident($attribute){
        if(!$this->hasErrors()){
            $user = User::findIdentity($this->president_user_id);
            $auth = Yii::$app->authManager;
            $userRoleCheck = $auth->getAssignment('admin', $this->president_user_id) !== null 
              || $auth->getAssignment('clubPresident', $this->president_user_id) !== null;
            if($userRoleCheck && $user->club_id != null) $this->addError($attribute, 'Этот пользователь уже является председателем клуба');
        }
    }
    
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $club = new Club();
        $club->name = $this->name;
        $club->balance = 0;
        $club->save();
        $club->setNewPresident($this->president_user_id);
        return $club ? $club : false;
    }
}
