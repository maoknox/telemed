<?php

/**
 * This is the model class for table "suscriptor_usuario".
 *
 * The followings are the available columns in table 'suscriptor_usuario':
 * @property integer $id_suscriptor
 * @property integer $id_municipio
 * @property integer $id_tipoid
 * @property string $nombre_suscriptor
 * @property string $apellidos_suscriptor
 * @property string $nit_suscriptor
 * @property string $direccion_suscriptor
 *
 * The followings are the available model relations:
 * @property CambioMedidor[] $cambioMedidors
 * @property MedidorSuscriptor[] $medidorSuscriptors
 * @property Municipio $idMunicipio
 * @property TipoIdentificacion $idTipo
 */
class SuscriptorUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suscriptor_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_suscriptor', 'required'),
			array('id_municipio, id_tipoid', 'numerical', 'integerOnly'=>true),
			array('nombre_suscriptor, apellidos_suscriptor', 'length', 'max'=>50),
			array('nit_suscriptor', 'length', 'max'=>15),
			array('direccion_suscriptor', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_suscriptor, id_municipio, id_tipoid, nombre_suscriptor, apellidos_suscriptor, nit_suscriptor, direccion_suscriptor', 'safe', 'on'=>'search'),
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
			'cambioMedidors' => array(self::HAS_MANY, 'CambioMedidor', 'id_suscriptor'),
			'medidorSuscriptors' => array(self::HAS_MANY, 'MedidorSuscriptor', 'id_suscriptor'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idTipo' => array(self::BELONGS_TO, 'TipoIdentificacion', 'id_tipoid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_suscriptor' => 'Id Suscriptor',
			'id_municipio' => 'Id Municipio',
			'id_tipoid' => 'Id Tipoid',
			'nombre_suscriptor' => 'Nombre Suscriptor',
			'apellidos_suscriptor' => 'Apellidos Suscriptor',
			'nit_suscriptor' => 'Nit Suscriptor',
			'direccion_suscriptor' => 'Direccion Suscriptor',
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
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_tipoid',$this->id_tipoid);
		$criteria->compare('nombre_suscriptor',$this->nombre_suscriptor,true);
		$criteria->compare('apellidos_suscriptor',$this->apellidos_suscriptor,true);
		$criteria->compare('nit_suscriptor',$this->nit_suscriptor,true);
		$criteria->compare('direccion_suscriptor',$this->direccion_suscriptor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuscriptorUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
