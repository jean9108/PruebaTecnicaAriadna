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
    public $temas;

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
            [['numero_radicado', 'titulo'], 'required', 'message' => 'El {attribute} no es válido'],
            [['temas'], 'required', 'message' => 'El/los {attribute} no es/son válido(s)'],
            [['fecha'], 'required', 'message' => 'La {attribute} no es válida'],
            [['estado'], 'default', 'value' => Yii::$app->params['estadoActivo']],
            [['user_id', 'numero_radicado', 'estado'], 'integer'],
            [['fecha_registro'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['titulo'], 'string'],
            [['hora'], 'string'],
            [['fecha'], 'validaFecha'],
            //Validación para el número de radicación
            [['numero_radicado'], 'match', 'pattern' => '/^[0-9]+$/i', 'message' => '{attribute} no es válido'],
            [['numero_radicado'], 'validarRadicado'],
            [['numero_radicado'], 'unique'],
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
            ':estado' => Yii::$app->params['estadoActivo']
        ])
        ->one();

        if(!empty ($radicado->id) && empty($this->id)):
            $this->addError('numero_radicado', 'Ya existe este número de Radicado');
        endif;
    }

    public function validaFecha($attribute,$params){

        if($this->fecha < Yii::$app->params['anioMin'] || $this->fecha > Yii::$app->params['anioMax']):
            $this->addError('fecha', 'Año invalido. El año debe estar entre el 2007 y el 2013');
        endif;
    }

    public function getFechas(){
        $anios = [];
        for($i = Yii::$app->params['anioMin']; $i <= Yii::$app->params['anioMax']; $i++):
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
