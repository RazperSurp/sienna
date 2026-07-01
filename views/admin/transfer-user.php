<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\user\User;
use app\models\club\Club;

$this->title = 'Админ: Перевод пользователя в клуб';
?>

<div class="admin-transfer" style="font-family: system-ui, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="margin-bottom: 24px; color: #333; font-size: 26px;"><?= Html::encode($this->title) ?></h1>

    <div style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <?php $form = ActiveForm::begin(); ?>
        <div style="margin-bottom: 16px;">
            <?= $form->field($model, 'userId')->dropDownList(ArrayHelper::map(
                    User::find()->all(),
                   'id',
                   'email')
                , [
                'prompt' => 'Выберите студента...',
                'style' => 'width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;'
            ]) ?>
        </div>
        <div style="margin-bottom: 20px;">
            <?= $form->field($model, 'clubId')->dropDownList(ArrayHelper::map(
                Club::find()->all(),
                'id',
                'name'
            ), [
                'prompt' => 'Выберите целевой клуб...',
                'style' => 'width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;'
            ]) ?>
        </div>

        <?= Html::submitButton('Перевести пользователя', [
            'class' => 'btn btn-primary',
            'style' => 'width: 100%; padding: 12px; font-weight: bold; border-radius: 6px; border: none; cursor: pointer; background: #007bff; color: #fff;'
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>