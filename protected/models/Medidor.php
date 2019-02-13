<?php

/**
 * This is the model class for table "medidor".
 *
 * The followings are the available columns in table 'medidor':
 * @property integer $id_medidor
 * @property integer $id_marca
 * @property integer $id_modelo
 * @property integer $id_estado
 * @property string $codigo_medidor
 * @property string $descripcion
 * @property string $digitos_medidor
 *
 * The followings are the available model relations:
 * @property CambioMedidor[] $cambioMedidors
 * @property CambioMedidor[] $cambioMedidors1
 * @property LecturaActual[] $lecturaActuals
 * @property Estado $idEstado
 * @property Marca $idMarca
 * @property Modelo $idModelo
 * @property MedidorSuscriptor[] $medidorSuscriptors
 */
class Medidor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'medidor';
	}
        public function getDbConnection(){
            return Yii::app()->dbi; // or return Yii::app()->db2;
        }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_medidor', 'required'),
			array('id_marca, id_modelo, id_estado', 'numerical', 'integerOnly'=>true),
			array('codigo_medidor', 'length', 'max'=>25),
			array('descripcion', 'length', 'max'=>500),
			array('digitos_medidor', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_medidor, id_marca, id_modelo, id_estado, codigo_medidor, descripcion, digitos_medidor', 'safe', 'on'=>'search'),
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
			'cambioMedidors' => array(self::HAS_MANY, 'CambioMedidor', 'id_medidor'),
			'cambioMedidors1' => array(self::HAS_MANY, 'CambioMedidor', 'med_id_medidor'),
			'lecturaActuals' => array(self::HAS_MANY, 'LecturaActual', 'id_medidor'),
			'idEstado' => array(self::BELONGS_TO, 'Estado', 'id_estado'),
			'idMarca' => array(self::BELONGS_TO, 'Marca', 'id_marca'),
			'idModelo' => array(self::BELONGS_TO, 'Modelo', 'id_modelo'),
			'medidorSuscriptors' => array(self::HAS_MANY, 'MedidorSuscriptor', 'id_medidor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_medidor' => 'Id Medidor',
			'id_marca' => 'Id Marca',
			'id_modelo' => 'Id Modelo',
			'id_estado' => 'Id Estado',
			'codigo_medidor' => 'Codigo Medidor',
			'descripcion' => 'Descripcion',
			'digitos_medidor' => 'Digitos Medidor',
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

		$criteria->compare('id_medidor',$this->id_medidor);
		$criteria->compare('id_marca',$this->id_marca);
		$criteria->compare('id_modelo',$this->id_modelo);
		$criteria->compare('id_estado',$this->id_estado);
		$criteria->compare('codigo_medidor',$this->codigo_medidor,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('digitos_medidor',$this->digitos_medidor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Medidor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
