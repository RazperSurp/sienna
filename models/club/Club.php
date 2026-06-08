<?php
namespace app\models\club;
use Yii;
use yii\db\ActiveRecord;
use app\models\user\User;

class Club extends ActiveRecord
{
    /**
     * @return string имя таблицы, связанной с этим классом
     */
    public static function tableName()
    {
        return '{{%clubs}}';
    }

    public function getAllMembers(){
        return User::findAll(['club_id' => $this->id]);
    }

    public static function findByName($clubName){
        $record = self::findOne(['name' => $clubName]);
        if(!$record) return null;
        return new static($record);
    }

    public static function findById($clubId){
        $record = self::findOne(['id' => $clubId]);
        if(!$record) return null;
        return new static($record);
    }

    public function setNewPresident($userId){
        $auth = Yii::$app->authManager;
        $user = User::findIdentity($userId);
        if (!$user) {
            return false;
        }
        if ($auth->getAssignment('admin', $userId) == null) {
            $user->changeRole('clubPresident');
        }
        $user->club_id = $this->id;
        return $user->save(); 
        }
}