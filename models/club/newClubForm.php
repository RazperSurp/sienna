<?php
namespace app\models\club;

use Yii;
use yii\base\Model;
use app\models\User;
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
        ];
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
        return $club->save() ? $club : false;
    }
}
