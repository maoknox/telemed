<?php

/**
 * This is the model class for table "medidor_suscriptor".
 *
 * The followings are the available columns in table 'medidor_suscriptor':
 * @property integer $id_suscriptor
 * @property integer $id_medidor
 * @property integer $id_tipouso
 * @property integer $id_estrato
 * @property integer $id_municipio
 * @property integer $id_empresa
 * @property string $direccion_medidor
 * @property string $interno_medidor
 * @property integer $ciclo_medidor
 * @property string $ruta_medidor
 * @property string $longitud_medidor
 * @property string $latitud_medidor
 *
 * The followings are the available model relations:
 * @property SuscriptorUsuario $idSuscriptor
 * @property Medidor $idMedidor
 * @property TipoUso $idTipouso
 * @property Estrato $idEstrato
 * @property Municipio $idMunicipio
 * @property Empresa $idEmpresa
 */
class MedidorSuscriptor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'medidor_suscriptor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_suscriptor, id_medidor, id_tipouso, id_estrato, id_municipio, id_empresa, direccion_medidor', 'required'),
			array('id_suscriptor, id_medidor, id_tipouso, id_estrato, id_municipio, id_empresa, ciclo_medidor', 'numerical', 'integerOnly'=>true),
			array('direccion_medidor', 'length', 'max'=>500),
			array('ruta_medidor', 'length', 'max'=>15),
			array('longitud_medidor, latitud_medidor', 'length', 'max'=>50),
			array('interno_medidor', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_suscriptor, id_medidor, id_tipouso, id_estrato, id_municipio, id_empresa, direccion_medidor, interno_medidor, ciclo_medidor, ruta_medidor, longitud_medidor, latitud_medidor', 'safe', 'on'=>'search'),
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
			'idSuscriptor' => array(self::BELONGS_TO, 'SuscriptorUsuario', 'id_suscriptor'),
			'idMedidor' => array(self::BELONGS_TO, 'Medidor', 'id_medidor'),
			'idTipouso' => array(self::BELONGS_TO, 'TipoUso', 'id_tipouso'),
			'idEstrato' => array(self::BELONGS_TO, 'Estrato', 'id_estrato'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idEmpresa' => array(self::BELONGS_TO, 'Empresa', 'id_empresa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_suscriptor' => 'Id Suscriptor',
			'id_medidor' => 'Id Medidor',
			'id_tipouso' => 'Id Tipouso',
			'id_estrato' => 'Id Estrato',
			'id_municipio' => 'Id Municipio',
			'id_empresa' => 'Id Empresa',
			'direccion_medidor' => 'Direccion Medidor',
			'interno_medidor' => 'Interno Medidor',
			'ciclo_medidor' => 'Ciclo Medidor',
			'ruta_medidor' => 'Ruta Medidor',
			'longitud_medidor' => 'Longitud Medidor',
			'latitud_medidor' => 'Latitud Medidor',
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

		$criteria->compare('id_suscriptor',$this->id_suscriptor);
		$criteria->compare('id_medidor',$this->id_medidor);
		$criteria->compare('id_tipouso',$this->id_tipouso);
		$criteria->compare('id_estrato',$this->id_estrato);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_empresa',$this->id_empresa);
		$criteria->compare('direccion_medidor',$this->direccion_medidor,true);
		$criteria->compare('interno_medidor',$this->interno_medidor,true);
		$criteria->compare('ciclo_medidor',$this->ciclo_medidor);
		$criteria->compare('ruta_medidor',$this->ruta_medidor,true);
		$criteria->compare('longitud_medidor',$this->longitud_medidor,true);
		$criteria->compare('latitud_medidor',$this->latitud_medidor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MedidorSuscriptor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
