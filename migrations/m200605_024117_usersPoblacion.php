<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m200605_024117_usersPoblacion
 */
class m200605_024117_usersPoblacion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Creación de usuarios
        $user = new User();
        $user->username = 'joana9108@gmail.com';
        $user->email = 'joana9108@gmail.com';
        $user->setPassword('123456789');
        $user->generateAuthKey();
        $user->save(false);

        $user = new User();
        $user->username = 'joana.garcia@gmail.com';
        $user->email = 'joana.garcia@gmail.com';
        $user->setPassword('123456789');
        $user->generateAuthKey();
        $user->save(false);

        $user = new User();
        $user->username = 'pepe@gmail.com';
        $user->email = 'pepe@gmail.com';
        $user->setPassword('1234567890');
        $user->generateAuthKey();
        $user->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%users}}');
    }
}
