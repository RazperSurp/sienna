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
$presidentName = '';
if ($model->president_user_id) {
    // Замените \app\models\User на вашу реальную модель пользователя, если она называется иначе
    $user = \app\models\user\User::findOne($model->president_user_id);
    // Предполагаем, что в модели User есть свойство fullname или username
    $presidentName = $user ? ($user->fullname ?? $user->username) : ''; 
}
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'president_user_id')->widget(Select2::classname(), [
        'initValueText' => $presidentName, // Выводим имя найденного пользователя
        'options' => ['placeholder' => 'Поиск и выбор президента клуба...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3, 
            'language' => 'ru', 
            'ajax' => [
                'url' => Url::to(['user/search-users']), 
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q: params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(item) { return item.text; }'),
            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
