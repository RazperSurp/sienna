<?php 
namespace app\models\user;
use Yii;
use yii\base\Model;
use app\models\club\Club;

class AdminTransferForm extends Model {
    public $userId;
    public $clubId;

    public function rules() {
        return [
            [['userId', 'clubId'], 'required'],
            [['userId', 'clubId'], 'integer'],
            ['userId', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
            ['clubId', 'exist', 'targetClass' => Club::class, 'targetAttribute' => ['clubId' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'userId' => 'выберите пользователя',
            'clubId' => 'выберите новый клуб',
        ];
    }
}

?>