<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\admin\CreateEvent $model */
/** @var array $clubs */
/** @var array $events */
$clubs = \app\models\club\Club::find()->asArray()->all();
$events = \app\models\event\Event::find()->where(['status' => true])->asArray()->all();
$this->title = 'Управление ивентами';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    <style>
    </style>
</head>

<body class="create-event-body">

    <?= $this->render('//layouts/header') ?>

    <div class="page-container">
        
        <main class="main-create-event">
            
            <form class="card-block" method="post" action="<?= Url::to(['admin/create-event']) ?>">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="block-title">
                    <h1>Создать ивент</h1>
                </div>
                
                <div class="form-group">
                    <label for="name-event">Название ивента</label>
                    <input type="text" name="CreateEvent[name]" id="name-event" class="form-control" placeholder="Название ивента">
                </div>
                
                <div class="form-group">
                    <label for="clubs">Привязать к клубу</label>
                    <select name="CreateEvent[club]" id="clubs" class="form-control">
                        <option disabled selected hidden>-- Выберите клуб --</option>
                    </select>
                </div>

                <button type="submit" class="button-create-event">Создать ивент</button>
            </form>

            <form class="card-block" method="post" action="<?= Url::to(['admin/close-event']) ?>">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="block-title">
                    <h1>Завершить ивент</h1>
                </div>

                <div class="form-group">
                    <label for="event">Выберите ивент для завершения</label>
                    <select name="CloseEvent[event]" id="event" class="form-control">
                        <option disabled selected hidden>-- Активные ивенты --</option>
                    </select>
                </div>

                <button type="submit" class="button-end-event">Завершить ивент</button>
            </form>

        </main>

        <a href="admin" class="button-back">← Назад в админ-панель</a>

    </div>
</body>
</html>
<script>
    const clubs = <?= json_encode($clubs ?? []); ?>;
    const events = <?= json_encode($events ?? []); ?>;
    clubs.forEach(club =>{
        let option = document.createElement('option');
        option.textContent = club.name;
        option.value = club.id;
        document.getElementById('clubs').appendChild(option)
    });

    events.forEach(event => {
        let option = document.createElement('option');
        option.value = event.id;
        option.textContent = event.name;
        document.getElementById('event').appendChild(option);
    });
</script>