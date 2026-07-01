<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Роспуск (удаление) клуба';
$this->params['breadcrumbs'][] = ['label' => 'Клубы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Удаление';
?>
<div class="club-delete-form" style="max-width: 600px; margin: 20px auto; font-family: system-ui, sans-serif;">
    <div class="alert alert-danger" style="padding: 20px; border-radius: 4px; background-color: #f2dede; border-color: #ebccd1; color: #a94442;">
        <h3 style="margin-top: 0;">Внимание! Действие администратора / председателя</h3>
        <p>Удаление клуба приведет к мгновенному расторжению контрактов со всеми участниками. История транзакций клуба будет полностью очищена.</p>
    </div>
    <?php $form = ActiveForm::begin([
        'action' => ['club/delete-club'],
        'method' => 'post',
    ]); ?>
    <div style="margin-bottom: 24px;">
        <?= $form->field($model, 'clubId')->dropDownList($clubsList, [
            'prompt' => 'Выберите клуб для ликвидации...',
            'style' => 'width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;'
        ])->label('Какой клуб распустить?') ?>
    </div>
    <div class="form-group" style="margin-top: 20px; display: flex; gap: 10px;">
        <?= Html::submitButton('Да, распустить клуб навсегда', [
            'class' => 'btn btn-danger', 
            'style' => 'background-color: #d9534f; border-color: #d43f3a; color: #fff; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; border: none;'
        ]) ?>
        <?= Html::a('Отмена', ['index'], [
            'class' => 'btn btn-default',
            'style' => 'background-color: #fff; border: 1px solid #ccc; color: #333; padding: 12px 20px; border-radius: 4px; text-decoration: none; display: inline-block;'
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>