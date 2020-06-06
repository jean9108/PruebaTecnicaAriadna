<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use rmrevin\yii\fontawesome\FA;

$this->title = 'Iniciar Sessión';
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 form-box-login">
            <div class="form-top">
                <h4 class="card-title text-center mb-4 mt-1">
                    <?= Html::encode($this->title) ?>
                </h4>
                <hr />
            </div><!--end form-top-->

            <div class="form-bottom ">
                <div class="form-group">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'username', [
                             'inputOptions' => [
                                'placeholder' => 'Email',
                            ],
                            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">'.FA::icon('user').'</span>{input}</div>'
                            ]
                        )->label(false) ?>
                    </div>
                </div><!--end form-group--->
                <div class="form-group">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'password',[
                            'inputOptions' => [
                                'placeholder' => 'Contraseña',
                                'type' => 'password'
                            ],
                            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">'.FA::icon('key').'</span>{input}</div>'
                            ]
                        )->label(false) ?>
                    </div>
                </div><!--end form-group--->
                <div class="form-group">
                    <div class="col-sm-12 inicio-seccion">
                        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-danger btn-block', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div><!--end form-bottom-->
        </div><!-- end form-box-login-->
    </div><!--End row-->

    <?php ActiveForm::end(); ?>
</div>
