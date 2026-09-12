<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\admin\Transaction;
/** @var app\models\club\Club $clubInfo */
$club = $clubInfo;

$members = $club->getAllMembers();
$membersData = [];
foreach ($members as $member) {
    $membersData[] = [
        'name' => $member->getFullName(),
        'role' => $member->getRole()
    ];
}
$events = $club->getAllEvents();
$transactions = Transaction::find()->where(['club_id' => $club->id])->orderBy(['id' => SORT_DESC])->limit(20)->asArray()->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    </head>
<body class="club-body">
  <?= $this->render('//layouts/header') ?>
    <div class="club-page">
    <div class="club-main">
            <div class="club-card">
                <h1 id="club-name"></h1>
                <h2>Информация о клубе</h2>
                <p>Баланс: <span id="club-balance"></span> баллов</p>
                <p>Участников: <span id="members-count"></span></p>
                <p>Мероприятий: <span id="events-count"></span></p>
            </div>
            <div class="club-card">
                <h2>Участники клуба</h2>
                <table class="members-table">
                    <tbody id="members-list"></tbody>
                </table>
            </div>
        </div>
        <div class="club-history">
            <h2>История операций</h2>
            <div class="history-list" id="history-list"></div>
        </div>

    </div>
<template id="member-template">
    <tr>
        <td>ФИО: <span class="member-name"></span></td>
        <td>Роль: <span class="member-role"></span></td>
    </tr>
</template>

<template id="history-template">
    <div class="history-item">
        <div class="history-value"></div>
        <div>Комментарий к транзакции:<span class="history-comment"></span></div>
    </div>
</template>
</body>
<script>

const club = <?= json_encode($club->toArray()) ?>;
const members = <?= json_encode($membersData) ?>;
const events = <?= json_encode($events ?? [] ) ?>;
let roles = {admin: 'Администратор', clubPresident: 'Президент', clubMember: 'Участник'};
const transactions = <?= json_encode($transactions) ?>;
document.getElementById('club-name').textContent = club.name;
document.getElementById('club-balance').textContent = club.balance;
document.getElementById('members-count').textContent = members.length;
document.getElementById('events-count').textContent = events.length;
members.forEach(member => {

    let card = document.getElementById('member-template').content.cloneNode(true);

    card.querySelector('.member-name').textContent = member.name;
    card.querySelector('.member-role').textContent = roles[member.role];

    document.getElementById('members-list').appendChild(card);
});


transactions.forEach(transaction => {

    const card = document.getElementById('history-template').content.cloneNode(true);
    card.querySelector('.history-comment').textContent = transaction.comment || 'Без комментария';

    card.querySelector('.history-value').textContent = transaction.value;
    document.getElementById('history-list').appendChild(card);
});

</script>
</html>