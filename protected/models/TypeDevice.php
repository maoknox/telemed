<?php

/**
 * This is the model class for table "type_device".
 *
 * The followings are the available columns in table 'type_device':
 * @property integer $id_type_device
 * @property string $devicetype_code
 * @property string $devicetype_label
 * @property string $devicetype_description
 *
 * The followings are the available model relations:
 * @property Device[] $devices
 */
class TypeDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'type_device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('devicetype_code, devicetype_label', 'required'),
			array('devicetype_code, devicetype_label', 'length', 'max'=>50),
			array('devicetype_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_type_device, devicetype_code, devicetype_label, devicetype_description', 'safe', 'on'=>'search'),
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
			'devices' => array(self::HAS_MANY, 'Device', 'id_type_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_type_device' => 'Id Type Device',
			'devicetype_code' => 'Devicetype Code',
			'devicetype_label' => 'Devicetype Label',
			'devicetype_description' => 'Devicetype Description',
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

		$criteria->compare('id_type_device',$this->id_type_device);
		$criteria->compare('devicetype_code',$this->devicetype_code,true);
		$criteria->compare('devicetype_label',$this->devicetype_label,true);
		$criteria->compare('devicetype_description',$this->devicetype_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeDevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
