<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\user\User;
use app\models\club\Club;

/** @var yii\web\View $this */
/** @var app\models\club\NewClubForm $model */

$this->title = 'Управление клубами';
$users = $users ?? User::find()->where(['club_id' => null])->asArray()->all();
$clubs = $clubs ?? Club::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta name="csrf-token" content="<?= Yii::$app->request->getCsrfToken() ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
</head>

<body class="admin-clubs">
    <?= $this->render('//layouts/header') ?>

    <div class="page-container">
        <main class="main-admin-clubs">
            
            <div class="card-block">
                <div class="block-title">
                    <h1>Создать клуб</h1>
                </div>
                <form id="create-club-form" action="<?= Url::to(['admin/create-club']) ?>" method="post">
                   <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                    <div class="form-group">
                        <label for="club-name">Название Клуба</label>
                        <input name="NewClubForm[name]" type="text" id="club-name" class="form-control" placeholder="Название клуба" maxlength="80">
                    </div>
    
                    <div class="form-group">
                        <label for="president_user_id">Выбор председателя</label>
                        <select id="president_user_id" name="NewClubForm[president_user_id]" class="form-control">
                            <option disabled selected hidden>-- Выберите председателя клуба --</option>
                        </select>
                    </div>
    
                    <button type="submit" class="button-create-club">Создать клуб</button>
                </form> 
            </div>

            <div class="card-block">
                <div class="block-title">
                    <h1>Список клубов</h1>
                </div>

                <div class="clubs-list-container" id="clubs-container">
                        
                
                </div>
            </div>

        </main>
        <a href="<?= Url::to(['admin/admin']) ?>" class="button-back">← Назад в админ-панель</a>
    </div>

    <template id="club-card-template">
        <div class="card-list">
            <div class="card-list-left-side">
                <h2 class="card-list-title"></h2>
            </div>
            <div class="card-list-right-side">
                <p><span class="clubs-point"></span> Баллов</p>
                <form class="delete-form" action="<?= Url::to(['club/delete-club']) ?>" method="post" onsubmit="return confirm('Удалить клуб?');">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                    <input type="hidden" name="BankForm[clubId]" class="club-id-input">
                    <button type="submit" class="delete-club">Удалить</button>
                </form>
            </div>
        </div>
    </template>
</body>
<script> 
let clubsData = <?= json_encode($clubs ?? []); ?>;
    function renderCards() {
        const container = document.getElementById('clubs-container');

        clubsData.forEach(club => {
            let card = document.getElementById('club-card-template').content.cloneNode(true);

            card.querySelector('.card-list-title').textContent = club.name;
            card.querySelector('.clubs-point').textContent = club.balance ?? 0;
            card.querySelector('.club-id-input').value = club.id;

            container.appendChild(card);
        });
    }
const users = <?= json_encode($users ?? []);  ?>;

users.forEach(user => {
    let option = document.createElement('option');

    option.value = user.id;
    option.textContent =`${user.first_name} ${user.second_name}`;

    document.getElementById('president_user_id').appendChild(option);
});

renderCards()
</script>
</html>