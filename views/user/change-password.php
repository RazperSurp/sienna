<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oldPassword')?>

    <?= $form->field($model, 'newPassword')?>

    <div class="form-group">
        <?= Html::submitButton('Сменить пароль', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
