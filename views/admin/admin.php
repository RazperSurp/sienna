<?php
use yii\helpers\Url;
use app\models\club\Club;
use app\models\event\Event;
use app\models\user\User;


$clubs = Club::find()->asArray()->all();
$events = Event::find()->asArray()->all();
$users = User::find()->asArray()->all();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/main.css">

    <style>

    </style>
</head>

<body class="admin-body">

    <?= $this->render('//layouts/header') ?>

    <div class="admin-container">
        <main>

            <div class="all-stats">
                <div class="card-stats">
                    <p class="stat-number" id="clubs-count"></p>
                    <p class="stat-label">Клубов</p>
                </div>
                <div class="card-stats">
                    <p class="stat-number" id="events-count"></p>
                    <p class="stat-label">Ивентов</p>
                </div>
                <div class="card-stats">
                    <p class="stat-number" id="users-count"></p>
                    <p class="stat-label">Пользователей</p>
                </div>
            </div>

            <div class="admin-managing">
                <a href="create-club" class="card-managing">
                    <span class="card-icon">🏛️</span>
                    <h3 class="card-title">Управление клубами</h3>
                    <p class="card-name">Создание и удаление клубов</p>
                </a>

                <a href="create-event" class="card-managing">
                    <span class="card-icon">🎯</span>
                    <h3 class="card-title">Управление ивентами</h3>
                    <p class="card-name">Создание и завершение ивентов</p>
                </a>

                <a href="<?= Url::to(['dev/create-user']) ?>" class="card-managing">
                    <span class="card-icon">👤</span>
                    <h3 class="card-title">Управление пользователями</h3>
                    <p class="card-name">Создание, смена пароля, перевод в клубы</p>
                </a>

                <a href="bank" class="card-managing">
                    <span class="card-icon">🏦</span>
                    <h3 class="card-title">Банк</h3>
                    <p class="card-name">Управление баллами клубов</p>
                </a>
            </div>

        </main>
    </div>

</body>
<script>
const clubs = <?= json_encode($clubs) ?>;
const events = <?= json_encode($events) ?>;
const users = <?= json_encode($users) ?>;

document.getElementById('clubs-count').textContent = clubs.length;
document.getElementById('events-count').textContent = events.length;
document.getElementById('users-count').textContent = users.length;
</script>
</html>