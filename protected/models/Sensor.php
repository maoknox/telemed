<?php

/**
 * This is the model class for table "sensor".
 *
 * The followings are the available columns in table 'sensor':
 * @property integer $serialid_sensor
 * @property integer $id_typesensor
 * @property string $id_sensor
 * @property string $sensor_name
 * @property string $sensor_brand
 * @property string $magnitude_min
 * @property string $magnitude_max
 * @property integer $sensor_associated
 *
 * The followings are the available model relations:
 * @property FactorSensor[] $factorSensors
 * @property TypeSensor $idTypesensor
 */
class Sensor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sensor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_typesensor, id_sensor, sensor_name, sensor_brand', 'required'),
			array('id_typesensor, sensor_associated', 'numerical', 'integerOnly'=>true),
			array('id_sensor', 'length', 'max'=>10),
			array('sensor_name', 'length', 'max'=>100),
			array('sensor_brand', 'length', 'max'=>500),
			array('magnitude_min, magnitude_max', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('serialid_sensor, id_typesensor, id_sensor, sensor_name, sensor_brand, magnitude_min, magnitude_max, sensor_associated', 'safe', 'on'=>'search'),
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
			'factorSensors' => array(self::HAS_MANY, 'FactorSensor', 'serialid_sensor'),
			'idTypesensor' => array(self::BELONGS_TO, 'TypeSensor', 'id_typesensor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'serialid_sensor' => 'Serialid Sensor',
			'id_typesensor' => 'Id Typesensor',
			'id_sensor' => 'Id Sensor',
			'sensor_name' => 'Sensor Name',
			'sensor_brand' => 'Sensor Brand',
			'magnitude_min' => 'Magnitude Min',
			'magnitude_max' => 'Magnitude Max',
			'sensor_associated' => 'Sensor Associated',
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

		$criteria->compare('serialid_sensor',$this->serialid_sensor);
		$criteria->compare('id_typesensor',$this->id_typesensor);
		$criteria->compare('id_sensor',$this->id_sensor,true);
		$criteria->compare('sensor_name',$this->sensor_name,true);
		$criteria->compare('sensor_brand',$this->sensor_brand,true);
		$criteria->compare('magnitude_min',$this->magnitude_min,true);
		$criteria->compare('magnitude_max',$this->magnitude_max,true);
		$criteria->compare('sensor_associated',$this->sensor_associated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sensor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
