<?php
use yii\widgets\DetailView;
use app\models\club\Club;

$user = \Yii::$app->user->identity;
echo DetailView::widget([
    'model' => $user,
    'attributes' => [
        'id',
        'second_name',
        'first_name',
        'third_name',
        'email',
        [
            'attribute' => 'role',
            'label' => 'Роль',
            'value' => function ($model) {
                $roles = Yii::$app->authManager->getRolesByUser($model->id);
                return $roles ? implode(', ', array_keys($roles)) : 'Нет роли';
            },
        ],
        [
            'attribute' => 'club',
            'label' => 'Клуб',
            'value' => function ($model) {
                $club = CLub::findById($model->club_id);
                return $club ? $club->name : 'Вы не состоите ни в одном клубе';
                // return ((CLub::findById($model->club_id))->name);
            },
        ],
    ],
]);
