<?php

use app\models\Radicados;
use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RadicadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Radicados';
?>
<div class="radicados-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr class = "mb-3"/>

    <?php
        if($dataProvider->getTotalCount()  == 0):
    ?>
        <div class="alert alert-info">
            <?= nl2br(Html::encode("No se encuentra ningún registro en las radicaciones ")) ?>
        </div>
    <?php else:?>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Email que Registro',
                        'attribute' => 'email',
                        'value' => 'email',
                    ],
                    'numero_radicado',
                    'titulo',
                    [
                        'attribute' => 'fecha',
                        'filter' => Radicados::getFechas(),
                        'value' => function($data){
                            return $data['fecha'];
                        }
                    ],
                    'hora',
                    [
                        'attribute' => 'estado',
                        'filter' =>['0' => 'Inactivo', '1' => 'Activo'],
                        'value' => function($data){
                            return ($data['estado'] == 0) ? 'Inactivo':'Activo';
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'headerOptions' => ['width' => '80'],
                        'template' => '{editar} {eliminar}',
                        'buttons'=>[
                            'editar' => function($url,$data){
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['update', 'id' => $data['id']]);
                            },
                            'eliminar' => function($url,$data){
                                return Html::a(FA::icon('trash'),['delete', 'id' => $data['id']]);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>

    <?php endif;?>
</div>
