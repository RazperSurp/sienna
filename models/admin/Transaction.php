<?php

namespace app\models\admin;

use Yii;
use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
    public static function tableName()
    {
        return 'transaction';
    }
    public function rules()
    {
        return [
            [['club_id', 'type', 'amount'], 'required'],
            [['club_id', 'amount'], 'integer'],
            ['type', 'in', 'range' => ['deposit', 'withdraw']],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }
}