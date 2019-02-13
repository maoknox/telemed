<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property integer $serialid_object
 * @property string $id_object
 * @property string $object_name
 * @property string $object_description
 *
 * The followings are the available model relations:
 * @property TypeGeography[] $typeGeographies
 * @property EntityDevice[] $entityDevices
 * @property ObjectUbication[] $objectUbications
 */
class ObjectOb extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_object, object_name, object_description', 'required'),
			array('id_object', 'length', 'max'=>1000),
			array('object_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('serialid_object, id_object, object_name, object_description', 'safe', 'on'=>'search'),
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
			'typeGeographies' => array(self::MANY_MANY, 'TypeGeography', 'geography_object(serialid_object, id_geography)'),
			'entityDevices' => array(self::HAS_MANY, 'EntityDevice', 'serialid_object'),
			'objectUbications' => array(self::HAS_MANY, 'ObjectUbication', 'serialid_object'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'serialid_object' => 'Serialid Object',
			'id_object' => 'Id Object',
			'object_name' => 'Object Name',
			'object_description' => 'Object Description',
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

		$criteria->compare('serialid_object',$this->serialid_object);
		$criteria->compare('id_object',$this->id_object,true);
		$criteria->compare('object_name',$this->object_name,true);
		$criteria->compare('object_description',$this->object_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Object the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
