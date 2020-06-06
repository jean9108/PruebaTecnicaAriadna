<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Radicados */

$this->title = 'Registrar Radicados';
?>
<div class="radicados-create">
    <div class = "row">
        <div class="col-sm-8 col-sm-offset-2 form-box-login">
            <div class="form-top">
                <h4 class="card-title text-center mb-4 mt-1">
                    <?= Html::encode($this->title) ?>
                </h4>
                <hr />
            </div><!--end form-top-->
            <div class="form-bottom ">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div><!--end col-sm-8-->
    </div><!-- end Row-->

</div>
