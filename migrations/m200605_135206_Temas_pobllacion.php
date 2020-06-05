<?php

use yii\db\Migration;

/**
 * Class m200605_135206_Temas_pobllacion
 */
class m200605_135206_Temas_pobllacion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('temas',
            ['nombre', 'descripcion', 'estado'],
            [
                ['Uno', '', Yii::$app->params['estadoActivo']],
                ['Dos', '',Yii::$app->params['estadoActivo']],
                ['Tres','',Yii::$app->params['estadoActivo']],
                ['Cuatro', '',Yii::$app->params['estadoActivo']]
            ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%temas}}');
    }
}
