<?php 
namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\club\Club;

class BankForm extends Model
{
    public $amount;     
    public $comment;    
    public $clubId;     

    public function rules(){
    return [
        [['clubId'], 'required'], 
        [['amount', 'comment'], 'safe'], 
        ['amount', 'integer'],
        ['comment', 'string', 'max' => 255],
        ['amount', 'validateBalance'],
    ];
}

    public function validateBalance($attribute, $params)
    {
        if ($this->amount < 0) {
            $club = Club::findOne($this->clubId);
            if ($club && $club->balance < abs($this->amount)) {
                $this->addError($attribute, 'На балансе клуба недостаточно токенов для снятия.');
            }
        }
    }

    public function joinClub($userId){
    
    if (!$this->validate()) {
        return false;
    }
    $user = \app\models\user\User::findOne($userId);
    $club = \app\models\club\Club::findOne($this->clubId);
    if (!$user || !$club) {
        return false;
    }
    return $user->changeClub($club->id);
    }

    public function executeTransaction(){
    if (!$this->validate()) {
        return false;
    }
    $transaction = Yii::$app->db->beginTransaction();
    try {
        $club = \app\models\club\Club::findOne($this->clubId);
        $club->balance += $this->amount;
        $club->save(false);

        $log = new \app\models\admin\Transaction(); 
        $log->club_id = $club->id;       
        $log->value = $this->amount;    
        $log->comment = $this->comment; 
        $log->save(false); 
        $transaction->commit();
        return true;
    } catch (\Exception $e) {
        $transaction->rollBack();
        return false;
    }
    }

}
?>