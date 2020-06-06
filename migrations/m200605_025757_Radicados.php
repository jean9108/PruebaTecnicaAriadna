<?php

use yii\db\Migration;

/**
 * Class m200605_025757_Radicados
 */
class m200605_025757_Radicados extends Migration
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

        $this->createTable('{{%radicados}}',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'numero_radicado' => $this->integer(6)->notNull()->unique(),
            'titulo' => $this->string()->notNull(),
            'fecha' => $this->integer(4)->notNull(),
            'hora' => $this->time(),
            'estado' => $this->smallInteger()->notNull()->defaultValue(1),
            'fecha_registro' =>  $this->timestamp()->notNull(),
        ],$tableOptions);

        $this->addForeignKey(
            'fk-radicados-user_id',
            '{{%radicados}}',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_id','radicados');
        $this->dropTable('{{%radicados}}');
    }
}
