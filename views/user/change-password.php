<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ChangePasswordForm $model */

$this->title = 'Смена пароля';
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
    <form class="form" id="login-form" action="<?= Url::to(['user/change-password']) ?>" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <div>
            <h1>Смена пароля</h1>
            <?php foreach ($model->getErrors() as $errors): ?>
                <div class="error-message">
                    <?= Html::encode($errors[0]) ?>
                </div>
            <?php endforeach; ?>
            <div class="oldPassword">
                <label for="oldPassword">Старый пароль</label>
                <input type="password" name="ChangePasswordForm[oldPassword]" id="oldPassword" placeholder="Введите старый пароль" minlength="8">
            </div>
            <div class="newPassword">
                <label for="changePassword">Новый пароль</label>
                <input type="password" name="ChangePasswordForm[newPassword]" id="changePassword" placeholder="Введите новый пароль" minlength="8">
            </div>
        </div>
        <div class="login">
            <button type="submit" id="login">Сменить пароль</button>
        </div>
        
    </form>
</body>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <script>
        window.location.href = "<?= Url::to(['user/index']) ?>";
    </script>
<?php endif; ?>
</html>