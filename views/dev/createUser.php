<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\club\Club;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'second_name') ?>

    <?= $form->field($model, 'third_name') ?>

    <?= $form->field($model, 'email') ?>
    
    <?php 
    $roles = Yii::$app->authManager->getRoles();
    $dataList = ArrayHelper::map($roles, 'name', 'name');
    ?>
    <?= $form->field($model, 'role')->dropDownList(
            $dataList,
            ['prompt' => 'Выберите значение...']
        ) 
    ?>

    <?php 
    $clubs = Club::find()->all();
    $dataList = ArrayHelper::map($clubs, 'id', 'name');
    ?>
    <?= $form->field($model, 'club')->dropDownList(
            $dataList,
            ['prompt' => 'Выберите значение...']
        ) 
    ?>

    <?= $form->field($model, 'password')->passwordInput()  ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>