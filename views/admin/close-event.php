<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\club\NewClubForm $model */
/** @var yii\widgets\ActiveForm $form */

// Инициализируем текст для уже выбранного пользователя (нужно при редактировании)
$eventName = '';
if ($model->event) {
    // Замените \app\models\User на вашу реальную модель пользователя, если она называется иначе
    $event = \app\models\event\Event::findOne($model->event);
    // Предполагаем, что в модели User есть свойство fullname или username
    $eventName = $event ? $event->name : ''; 
}
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event')->widget(Select2::classname(), [
        'initValueText' => $eventName, // Выводим имя найденного пользователя
        'options' => ['placeholder' => 'Поиск и выбор мероприятия...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3, 
            'language' => 'ru', 
            'ajax' => [
                'url' => Url::to(['admin/search-events']), 
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q: params.term, type: 1}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(item) { return item.text; }'),
            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Завершить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
