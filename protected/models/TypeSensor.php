<?php

/**
 * This is the model class for table "type_sensor".
 *
 * The followings are the available columns in table 'type_sensor':
 * @property integer $id_typesensor
 * @property string $sensor_type
 * @property string $sensor_description
 *
 * The followings are the available model relations:
 * @property Sensor[] $sensors
 */
class TypeSensor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'type_sensor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sensor_type, sensor_description', 'required'),
			array('sensor_type', 'length', 'max'=>50),
			array('sensor_description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_typesensor, sensor_type, sensor_description', 'safe', 'on'=>'search'),
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
			'sensors' => array(self::HAS_MANY, 'Sensor', 'id_typesensor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_typesensor' => 'Id Typesensor',
			'sensor_type' => 'Sensor Type',
			'sensor_description' => 'Sensor Description',
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

		$criteria->compare('id_typesensor',$this->id_typesensor);
		$criteria->compare('sensor_type',$this->sensor_type,true);
		$criteria->compare('sensor_description',$this->sensor_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeSensor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
