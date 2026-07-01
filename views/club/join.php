<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Выбор и вступление в клуб';
?>
<div class="club-join" style="font-family: system-ui, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px;">
    <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eee;">
        
        <h2 style="color: #333; margin-bottom: 20px; text-align: center;"><?= Html::encode($this->title) ?></h2>
        
        <?php $form = ActiveForm::begin(); ?>

        <div style="margin-bottom: 24px;">
            <?= $form->field($model, 'clubId')->dropDownList($clubsList, [
                'prompt' => 'Выберите клуб из списка...',
                'style' => 'width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;'
            ])->label('Доступные клубы') ?>
        </div>
        <div style="display: flex; gap: 12px;">
            <?= Html::submitButton('Подтвердить выбор', [
                'class' => 'btn btn-success',
                'style' => 'flex: 1; padding: 12px; font-weight: bold; border-radius: 6px; border: none; background: #28a745; color: #fff; cursor: pointer; font-size: 16px;'
            ]) ?>
            <?= Html::a('Отмена', ['index'], [
                'style' => 'padding: 12px 24px; text-decoration: none; color: #666; background: #e0e0e0; border-radius: 6px; font-weight: bold; font-size: 16px; text-align: center;'
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>