<?php

/**
 * This is the model class for table "lectura_actual".
 *
 * The followings are the available columns in table 'lectura_actual':
 * @property integer $id_lecturaactual
 * @property integer $id_critica
 * @property integer $id_medidor
 * @property string $lectura_actual
 * @property string $lectura_aforo
 * @property string $fecha_aforo
 * @property string $consumo_aforo
 * @property string $lectura_promedio
 * @property string $lectura_manual
 * @property string $lectura_micromedicion
 * @property string $metros_desviacion
 * @property string $problema_lectura
 * @property string $observacion_lectura
 * @property string $lectura_consumo
 *
 * The followings are the available model relations:
 * @property HistoricoLecturas[] $historicoLecturases
 * @property HistoricoConsumo[] $historicoConsumos
 * @property Critica $idCritica
 * @property Medidor $idMedidor
 */
class LecturaActual extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lectura_actual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_critica, id_medidor', 'numerical', 'integerOnly'=>true),
			array('lectura_actual, lectura_aforo, fecha_aforo, consumo_aforo, lectura_promedio, lectura_manual, lectura_micromedicion, metros_desviacion, problema_lectura, observacion_lectura, lectura_consumo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_lecturaactual, id_critica, id_medidor, lectura_actual, lectura_aforo, fecha_aforo, consumo_aforo, lectura_promedio, lectura_manual, lectura_micromedicion, metros_desviacion, problema_lectura, observacion_lectura, lectura_consumo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'historicoLecturases' => array(self::HAS_MANY, 'HistoricoLecturas', 'id_lecturaactual'),
			'historicoConsumos' => array(self::HAS_MANY, 'HistoricoConsumo', 'id_lecturaactual'),
			'idCritica' => array(self::BELONGS_TO, 'Critica', 'id_critica'),
			'idMedidor' => array(self::BELONGS_TO, 'Medidor', 'id_medidor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_lecturaactual' => 'Id Lecturaactual',
			'id_critica' => 'Id Critica',
			'id_medidor' => 'Id Medidor',
			'lectura_actual' => 'Lectura Actual',
			'lectura_aforo' => 'Lectura Aforo',
			'fecha_aforo' => 'Fecha Aforo',
			'consumo_aforo' => 'Consumo Aforo',
			'lectura_promedio' => 'Lectura Promedio',
			'lectura_manual' => 'Lectura Manual',
			'lectura_micromedicion' => 'Lectura Micromedicion',
			'metros_desviacion' => 'Metros Desviacion',
			'problema_lectura' => 'Problema Lectura',
			'observacion_lectura' => 'Observacion Lectura',
			'lectura_consumo' => 'Lectura Consumo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_lecturaactual',$this->id_lecturaactual);
		$criteria->compare('id_critica',$this->id_critica);
		$criteria->compare('id_medidor',$this->id_medidor);
		$criteria->compare('lectura_actual',$this->lectura_actual,true);
		$criteria->compare('lectura_aforo',$this->lectura_aforo,true);
		$criteria->compare('fecha_aforo',$this->fecha_aforo,true);
		$criteria->compare('consumo_aforo',$this->consumo_aforo,true);
		$criteria->compare('lectura_promedio',$this->lectura_promedio,true);
		$criteria->compare('lectura_manual',$this->lectura_manual,true);
		$criteria->compare('lectura_micromedicion',$this->lectura_micromedicion,true);
		$criteria->compare('metros_desviacion',$this->metros_desviacion,true);
		$criteria->compare('problema_lectura',$this->problema_lectura,true);
		$criteria->compare('observacion_lectura',$this->observacion_lectura,true);
		$criteria->compare('lectura_consumo',$this->lectura_consumo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LecturaActual the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
