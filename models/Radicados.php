<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "radicados".
 *
 * @property int $id
 * @property int $user_id
 * @property int $numero_radicado
 * @property string $titulo
 * @property string $temas
 * @property int $fecha
 * @property string $hora
 * @property int $estado
 * @property string $fecha_registro
 *
 * @property Users $user
 */

class Radicados extends \yii\db\ActiveRecord
{
    //Estado
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;

    //Año
    const ANIO_MIN = 2007;
    const ANIO_MAX = 2013;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'radicados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero_radicado', 'titulo', 'temas', 'fecha'], 'required', 'message' => '{attribute} no es válido'],
            [['estado'], 'default', 'value' => self::STATUS_ACTIVE],
            [['user_id', 'numero_radicado', 'estado'], 'integer'],
            [['fecha_registro'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['titulo'], 'string'],
            [['hora'], 'string'],
            [['fecha'], 'validaFecha'],
            //Validación para el número de radicación
            //[['numero_radicado'], 'match', 'pattern' => '/^{6,6}$/', 'message' => '{attribute} incorrecto'],
            [['numero_radicado'], 'match', 'pattern' => '/^[0-9]+$/i', 'message' => '{attribute} no es válido'],
            [['numero_radicado'], 'unique'],
            [['numero_radicado'], 'validarRadicado'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'numero_radicado' => 'Numero Radicado',
            'titulo' => 'Titulo',
            'temas' => 'Temas',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'estado' => 'Estado',
            'fecha_registro' => 'Fecha Registro',
        ];
    }


    public function validarRadicado($attribute,$params){
        $radicado = $this->find()
        ->where('numero_radicado = :numero_radicado')
        ->andWhere('estado = :estado')
        ->addParams([
            ':numero_radicado' => $this->numero_radicado,
            ':estado' => self::STATUS_ACTIVE
        ])
        ->one();

        if(!empty ($radicado->id) && empty($this->id)):
            $this->addError('numero_radicado', 'Ya existe este número de Radicado');
        endif;
    }

    public function validaFecha($attribute,$params){

        if($this->fecha < self::ANIO_MIN || $this->fecha > self::ANIO_MAX):
            $this->addError('fecha', 'Año invalido. El año debe estar entre el 2007 y el 2013');
        endif;
    }

    public function getFechas(){
        $anios = [];
        for($i = self::ANIO_MIN; $i <= self::ANIO_MAX; $i++):
            $anios[$i] = $i;
        endfor;
        return $anios;
    }

    public function getTemas(){
        $query  =  new Query();
        $query->select(['id_tema', 'nombre'])
            ->from('temas')
            ->where('estado = :estado',[':estado' => Yii::$app->params['estadoActivo']]);
        $temas = $query->all();

        return ArrayHelper::map($temas,(string)'id_tema', 'nombre');

    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
