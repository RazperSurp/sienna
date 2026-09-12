<?php

use yii\helpers\Html;
use app\models\event\Event;
use app\models\admin\Transaction;
/** @var app\models\user\User $user */
$eventsCount = Event::find()->where(['club_id' => $user->club_id])->count();
$earnedPoints = Transaction::find()->where(['club_id' => $user->club_id])->andWhere(['>', 'value', 0])->sum('value');
$clubBalance = $user->club->balance ?? null;
$this->title = 'Профиль';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
</head>
<style>
    
    
</style>
<body class="profile-body">
    <?= $this->render('//layouts/header') ?>
    <main class="profile-main">
        <div class="all-info-user">
            <div class="user-info">
                <h1>Информация о пользователи</h1>
                <table class="profile-table">
                    <tbody>
                        <tr>
                            <td class="name-info">ФИО</td>
                            <td class="info" id="full-name"></td>
                        </tr>
                        <tr>
                            <td class="name-info">Клуб</td>
                            <td class="info" id="club-name"></td>
                        </tr>
                        <tr>
                            <td class="name-info">Роль</td>
                            <td class="info" id="role-name"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="logout-wrapper" style="margin-top: 15px;">
                    <form action="<?= \yii\helpers\Url::to(['/user/logout']) ?>" method="post">
                       <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>"> 
                       <button type="submit" class="logout-button">Выйти из аккаунта</button>
                    </form>
                </div>
                <div class="change-password">
                    <a href="<?= \yii\helpers\Url::to(['user/change-password']) ?>">
                        <button type="button" class="button-change-password">Сменить пароль</button>
                    </a>
                </div>
            </div>
            
            <div class="club-stats">
                <h1>Статистика клуба</h1>
                <div>
                    <p>Участий:<span id="events-count"></span></p>
                    <p>Заработанно баллов:<span id="earned-points"></span></p>
                    <p>Баллов сейчас:<span id="club-balance"></span></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<script>
    const club = <?= json_encode(['eventsCount' => $eventsCount,'earnedPoints' => $earnedPoints,'clubBalance' => $clubBalance]);?>;
    const user = <?= json_encode(['fullName' => $user->getFullName(),'club' => $user->club ? $user->club->name : 'Не состоит','role' => $user->role]) ?>;
const roles = {
    admin: 'Администратор',
    clubPresident: 'Президент клуба',
    clubMember: 'Участник клуба'
};

document.getElementById('full-name').textContent = user.fullName;
document.getElementById('club-name').textContent = user.club;
document.getElementById('role-name').textContent = roles[user.role] ?? role;

document.getElementById('events-count').textContent = club.eventsCount;
document.getElementById('earned-points').textContent = club.earnedPoints ?? 'не в клубе';
document.getElementById('club-balance').textContent = club.clubBalance ?? 'не в клубе'

</script>