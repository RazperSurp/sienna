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
                    if(Yii::$app->authManager->checkAccess($member->id, 'clubPresident') || Yii::$app->authManager->checkAccess($member->id, 'admin')){
                        $owners[] = $member->getFullName();
                    }
                }
                // var_dump($owners);
                // exit;
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
        [
            'attribute' => 'events',
            'label' => 'events',
            'format' => 'raw',
            'value' => function($model) {
                $events = Club::findByName($model->name)->getAllEvents();
                $eventsLies = [];
                foreach ($events as $event) {
                    $bgColor = $event['status'] ? 'lightgreen' : 'lightcoral';
                    $eventsLies[] = Html::tag('li', Html::encode($event['name']), [
                        'style' => "background-color: {$bgColor};"
                    ]);
                }

                return Html::tag('ul', implode("\n", $eventsLies));
            }
        ],
    ],
]);
