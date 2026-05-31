<?php
use yii\widgets\DetailView;

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
    ],
]);
