<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\club\Club;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\club\NewClubForm $model */
/** @var yii\widgets\ActiveForm $form */

$clubName = '';
if ($model->club) {
    $club = \app\models\club\Club::findOne($model->club);
    $clubName = $club ? $club->name : ''; 
}
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    

    <?= $form->field($model, 'club')->widget(Select2::classname(), [
        'initValueText' => $clubName,
        'options' => ['placeholder' => 'Поиск и выбор клуба...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3, 
            'language' => 'ru', 
            'ajax' => [
                'url' => Url::to(['club/search-clubs']), 
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q: params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(item) { return item.text; }'),
            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>