<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Банковские операции клуба';
?>

<div class="club-bank" style="font-family: system-ui, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    <h1 style="margin-bottom: 24px; color: #333; font-size: 28px;"><?= Html::encode($this->title) ?></h1>

    <div style="display: flex; gap: 24px; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 300px; max-width: 500px; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eee;">
            
            <?php $form = ActiveForm::begin(['id' => 'bank-operation-form']); ?>

            <div style="margin-bottom: 16px;">
                <?= $form->field($model, 'clubId')->dropDownList($clubsList, [
                    'prompt' => 'Выберите клуб для операции...',
                    'style' => 'width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;'
                ])->label('Целевой клуб') ?>
            </div>

            <div style="margin-bottom: 16px;">
                <?= $form->field($model, 'amount')->textInput([
                    'type' => 'number', 
                    'placeholder' => 'Пример: 100 для пополнения, -50 для снятия...',
                    'style' => 'width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;'
                ])->label('Сумма токенов (укажите минус для снятия)') ?>
            </div>

            <div style="margin-bottom: 20px;">
                <?= $form->field($model, 'comment')->textInput([
                    'placeholder' => 'Укажите причину перевода/списания...',
                    'style' => 'width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;'
                ])->label('Комментарий к операции') ?>
            </div>

            <?= Html::submitButton('Подтвердить операцию', [
                'class' => 'btn btn-success',
                'style' => 'width: 100%; padding: 12px; font-weight: bold; border-radius: 6px; border: none; cursor: pointer; background-color: #28a745; color: white;'
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>