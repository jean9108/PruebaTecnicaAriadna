<?php

use yii\db\Migration;

/**
 * Class m200605_134801_Temas
 */
class m200605_134801_Temas extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql'):
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        endif;

        $this->createTable('{{%temas}}', [
            'id_tema' => $this->primaryKey(),
            'nombre' => $this->string()->notNull()->unique(),
            'descripcion' => $this->string(),
            'estado' => $this->smallInteger()->notNull()->defaultValue(1),
            'fecha_registro' => $this->timestamp()
        ],
        $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temas}}');
    }
}
