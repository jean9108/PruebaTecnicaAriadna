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
                'options' => ['placeholder' => 'Select a state ...', 'multiple' => true, 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]
        ) 
    ?>

    <?= $form->field($model, 'fecha')->dropDownList($model->getFechas(),['prompt' => 'Seleccione el año ...']) ?>

    <?=
        $form->field($model,'hora')->
        widget(TimePicker::classname(),[
            'addonOptions' => [
                'asButton' => true,
                'buttonOptions' => ['class' => 'btn btn-info']
            ]
        ])->label();
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
