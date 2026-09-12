<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

$this->title = 'Вход в аккаунт';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Yii::$app->request->getCsrfToken() ?>">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../css/main.css">
</head>

<body>
    <form class="form" id="login-form" action="<?= Url::to(['user/login']) ?>" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <div>
            <h1>Вход в аккаунт</h1>
            <?php if ($model->hasErrors()): ?>
                <div class="error-message">
                    <?= Html::encode($model->getFirstError('password')) ?>
                </div>
            <?php endif; ?>
            <div class="email">
                <label for="login-email">Почта</label>
                <input type="email" name="LoginForm[email]" id="login-email" placeholder="example@gmail.com">
            </div>
            <div class="password">
                <label for="login-password">Пароль</label>
                <input type="password" name="LoginForm[password]" id="login-password" placeholder="********" minlength="8">
            </div>
        </div>
        <div class="login">
            <button type="submit" id="login">Войти</button>
        </div>
    </form>
</body>

</html>