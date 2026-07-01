<?php

namespace app\models\club;
use Yii;
use yii\base\Model;
use app\models\club\Club;
use app\models\user\User;

class JoinClubForm extends Model {
    public $clubId; 

    public function rules(){
        return [
            [['clubId'], 'required'],
            [['clubId'], 'integer'],
            ['clubId', 'exist', 'targetClass' => Club::class, 'targetAttribute' => ['clubId' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'clubId' => 'Выберите клуб из списка',
        ];
    }

    public function join($userId){
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne($userId);
        if (!$user) {
            return false;
        }

        return $user->changeClub($this->clubId);
    }
}