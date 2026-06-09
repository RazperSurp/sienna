<?php

namespace app\models\event;

use Yii;
// use app\models\club\Club;
use yii\db\Query;

class Event extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%events}}';
    }

    public static function findById($id){
        $event = self::findOne($id);
        return $event ? $event : null;
    }

    public static function findByName($name){
        $event = self::findOne(['name' => $name]);
        return $event ? $event : null;
    }

    public function close(){
        $this->status = false;
        return $this->status == false;
    }

    // true - open , false - closed , null - any
    public static function findAlikeByName($name, $status = null){
        $query = (new Query())
        ->select(['*', 'name AS text'])
        ->from('events')
        ->where(['like', 'name', $name . '%', false]) 
        ->limit(20);

        if ($status !== null) {
            $query->andWhere(['status' => (bool)$status]);
        }

        $data = $query->all();

        return array_values($data);
    }

}
