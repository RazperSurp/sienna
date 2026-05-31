<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\models\user\User;
use app\models\club\Club;

echo DetailView::widget([
    'model' => $clubInfo,
    'attributes' => [
        'id',
        'name',
        'balance',
        [
            'attribute' => 'owner',
            'label' => 'owner',
            'value' => function ($model) {
                $members = (Club::findByName($model->name))->getAllMembers();
                $owners = [];
                foreach($members as $member){
                    if(Yii::$app->authManager->checkAccess($member->id, 'clubPresident')){
                        $owners[] = $member->getFullName();
                    }
                }
                return implode(' , ' , $owners);
            },
        ],
        [
            'attribute' => 'members',
            'label' => 'members',
            'format' => 'raw',
            'value' => function($model) {
                $members = Club::findByName($model->name)->getAllMembers();
                $membersFullnames = [];

                foreach ($members as $member) {
                    $membersFullnames[] = Html::tag('li', Html::encode($member->getFullName()));
                }

                return Html::tag('ul', implode("\n", $membersFullnames));
            }
        ],
    ],
]);
