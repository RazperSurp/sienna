<?php
namespace app\models\admin;

use Yii;
use yii\base\Model;
use app\models\event\Event;

class CloseEvent extends Model
{
    public $event;

    public function rules()
    {
        return [
            [['event'], 'required'],

            ['event' , 'validateEvent']
        ];
    }


    public function validateEvent($attribute , $params){
        if (!$this->hasErrors()) {
            $club = Event::findById($this->event);
            if (!$club) {
                $this->addError($attribute, 'Указанное мероприятие не найдено.');
            }
        }
    }


    public function close(){
        if(!$this->validate()) return false;
        $event = Event::findById($this->event);
        $event->status = false;
        return $event->save() ? $event : false;
    }
}