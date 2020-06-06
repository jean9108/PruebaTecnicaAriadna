<?php
use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Radicados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="radicados-form">

    <?php $form = ActiveForm::begin([
        'id' =>'radicado_form',
        'method' => 'POST',
        'enableClientValidation' => false,
        'enableAjaxValidation'=>true
    ]); ?>

    <?= $form->field($model, 'numero_radicado')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= 
        $form->field($model, 'temas')->widget(
            Select2::classname(),[
                'data' => $model->getTemas(),
                'theme' => Select2::THEME_MATERIAL,
                'options' => ['placeholder' => 'Selecciona ...', 'multiple' => true, 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]
            );
    ?>

    <?= 
        $form->field($model,'fecha')->widget(
            Select2::classname(),[
                'data' => $model->getFechas(),
                'theme' => Select2::THEME_MATERIAL,
                'options' => ['placeholder' => 'Seleccione ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]
        );
    ?>

    <?=
        $form->field($model,'hora')->
        widget(TimePicker::classname(),[
            'addonOptions' => [
                'asButton' => true,
                'buttonOptions' => ['class' => 'btn btn-danger']
            ]
        ])->label();
    ?>
    <br />
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-danger btn-block mt-5']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
