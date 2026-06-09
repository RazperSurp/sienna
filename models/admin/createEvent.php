<?php
namespace app\models\admin;

use Yii;
use yii\base\Model;
use app\models\club\Club;
use app\models\event\Event;

class CreateEvent extends Model
{
    public $name;
    public $club;

    public function rules()
    {
        return [
            [['name', 'club'], 'required'],

            ['name', 'string'],

            ['club', 'validateClub'],
        ];
    }


    public function validateClub($attribute , $params){
        if (!$this->hasErrors()) {
            $club = Club::findById($this->club);
            if (!$club) {
                $this->addError($attribute, 'Указанный клуб не найден.');
            }
        }
    }


    public function create(){
        if(!$this->validate()) return false;
        $event = new Event;
        $event->name = $this->name;
        $event->club_id = $this->club;
        return $event->save() ? $event : false;
    }
}