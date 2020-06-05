<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Radicados */

$this->title = 'Create Radicados';
$this->params['breadcrumbs'][] = ['label' => 'Radicados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="radicados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
