<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\dev\createUser $model */
/** @var array $users */
/** @var array $clubs */

$this->title = 'Управление пользователями';
$clubs = \app\models\club\Club::find()->asArray()->all();
$users = \app\models\user\User::find()->asArray()->all();
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



<body class="create-user-body">
    <?= $this->render('//layouts/header') ?>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="flash-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
        <?php elseif(Yii::$app->session->hasFlash('error')): ?>
            <div class="flash-error">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
    <?php endif; ?>
    <div class="page-container">
        
        <main class="main-create-user">
            
           
            <form class="card-block" id="create-user-form" method="post" action="<?= Url::to(['dev/create-user']) ?>">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="block-title">
                    <h1>Создать пользователя</h1>
                </div>

                <div class="form-group">
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Имя">
                </div>

                <div class="form-group">
                    <label for="second_name">Фамилия</label>
                    <input type="text" name="second_name" id="second_name" class="form-control" placeholder="Фамилия">
                </div>

                <div class="form-group">
                    <label for="third_name">Отчество</label>
                    <input type="text" name="third_name" id="third_name" class="form-control" placeholder="Отчество">
                </div>

                <div class="form-group">
                    <label for="email">Почта</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Почта">
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="123456" minlength="8">
                </div>

                <div class="form-group">
                    <label for="club">Клуб</label>
                    <select name="club" id="club" class="form-control">
                        <option disabled selected hidden>-- Выберите клуб --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Роль</label>
                    <select name="role" id="role" class="form-control">
                        <option  selected value="clubMember">Студент</option>
                        <option value="clubPresident">Преподаватель</option>
                        <option value="admin">Администратор</option>
                    </select>
                </div>
                <button type="submit" class="button-create-user">Создать пользователя</button>
            </form>

            
            <form class="card-block" id="change-password-form" action="<?= Url::to(['admin/change-password']) ?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="block-title">
                    <h1>Смена пароля</h1>
                </div>

                <div class="form-group">
                    <label for="user-pass">Пользователь</label>
                    <select name="ChangePassword[userId]" id="user-pass" class="form-control">
                        <option disabled selected hidden>-- Выберите пользователя --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="new-password">Новый пароль</label>
                    <input type="password" name="ChangePassword[newPassword]" id="new-password" class="form-control" placeholder="123456" minlength="8">
                </div>

                <button type="submit" class="button-change-password">Сменить пароль</button>
            </form>

            
            <form class="card-block" method="post" id="transfer-user-form" action="<?= Url::to(['admin/transfer-user']) ?>">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="block-title">
                    <h1>Смена клуба</h1>
                </div>

                <div class="form-group">
                    <label for="user-club">Пользователь</label>
                    <select name="AdminTransferForm[userId]" id="user-club" class="form-control">
                        <option disabled selected hidden>-- Выберите пользователя --</option>
                       
                    </select>
                </div>

                <div class="form-group">
                    <label for="new-club">Новый клуб</label>
                    <select name="AdminTransferForm[clubId]" id="new-club" class="form-control">
                        <option disabled selected hidden>-- Выберите клуб --</option>
                    </select>
                </div>

                <button type="submit" class="button-transfer-user">Перевести</button>
            </form>

        </main>
        <a href="admin" class="button-back">← Назад в админ-панель</a>

    </div>
</body>
<script>
    const users = <?= json_encode($users ?? []);  ?>;
    const clubs = <?= json_encode($clubs ?? []); ?>;
    users.forEach(user => {
        let option = document.createElement('option');
        let optionPass = document.createElement('option');

        option.value = user.id;
        option.textContent =`${user.first_name} ${user.second_name}`;

        document.getElementById('user-club').appendChild(option);

        optionPass.value = user.id;
        optionPass.textContent = `${user.first_name} ${user.second_name}`;
        document.getElementById('user-pass').appendChild(optionPass)
                            
    });
    clubs.forEach(club =>{
        let clubUser = document.createElement('option');
        let clubTransfer = document.createElement('option');

        clubUser.value = club.id;
        clubTransfer.value = club.id;

        clubUser.textContent = club.name;
        clubTransfer.textContent = club.name;

        document.getElementById('club').appendChild(clubUser)
        document.getElementById('new-club').appendChild(clubTransfer)
    })
    if(document.querySelector('.flash-success')){
        setTimeout(() => {
            document.querySelector('.flash-success').remove()
        }, 3000);
    }
    else if(document.querySelector('flash-error')){
        setTimeout(() => {
            document.querySelector('.flash-error').remove()
        }, 3000);
    }
</script>
</html>