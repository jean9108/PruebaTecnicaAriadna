<?php

use yii\db\Migration;

/**
 * Class m200605_225203_radicacionesTemas
 */
class m200605_225203_radicacionesTemas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql'):
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        endif;

        $this->createTable('{{%radicaciones_temas}}',[
            'id_tema' => $this->integer()->notNull(),
            'id_radicacion' => $this->integer()->notNull(),
            'estado' => $this->smallInteger()->notNull()->defaultValue(1),
        ],
        $tableOptions);

        //LLaves Foraneas
        $this->addForeignKey(
            'fk-radicaciones_temas-id_tema',
            'radicaciones_temas',
            'id_tema',
            'temas',
            'id_tema',
            'CASCADE');

        $this->addForeignKey(
            'fk-radicaciones_temas-id_radicaciones', 
            'radicaciones_temas',
            'id_radicacion',
            'radicados', 
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('id_radicacion','radicaciones_temas');
        $this->dropForeignKey('id_tema','radicaciones_temas');
        $this->dropTable('{{%radicaciones_temas}}');
    }
}
