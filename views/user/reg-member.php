<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\club\Club;
use app\models\user\User;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'second_name') ?>

    <?= $form->field($model, 'third_name') ?>

    <?= $form->field($model, 'email') ?>
    
    <?php
    if(Yii::$app->user->can('admin')){
        $clubs = Club::find()->all();
        $dataList = ArrayHelper::map($clubs, 'id', 'name');
        echo $form->field($model, 'club_id')->dropDownList(
            $dataList,
            ['prompt' => 'Выберите значение...']
        ) ->label('Club');
    }
    else{
        $identity = Yii::$app->user->identity;
    
        if ($identity && $identity->club) {
            $userClub = $identity->club;

            echo $form->field($model, 'club_id')->hiddenInput(['value' => $userClub->id])->label(false);

            echo '<div class="form-group">';
            echo '<label class="control-label">Club</label>';
            echo '<div class="form-control-static">' . Html::encode($userClub->name) . '</div>';
            echo '</div>';
        }
        else{
            echo '<label class="control-label">Вы не являетесь участником ни одного клуба</label>';
        }
    }
    
    ?>

    <?= $form->field($model, 'password')->passwordInput()  ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>