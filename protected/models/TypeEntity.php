<?php

/**
 * This is the model class for table "type_entity".
 *
 * The followings are the available columns in table 'type_entity':
 * @property integer $id_typeent
 * @property string $typeent_code
 * @property string $typeent_name
 * @property string $typeent_description
 *
 * The followings are the available model relations:
 * @property Entity[] $entities
 */
class TypeEntity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'type_entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeent_code, typeent_name', 'required'),
			array('typeent_code', 'length', 'max'=>3),
			array('typeent_name', 'length', 'max'=>500),
			array('typeent_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_typeent, typeent_code, typeent_name, typeent_description', 'safe', 'on'=>'search'),
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
			'entities' => array(self::HAS_MANY, 'Entity', 'id_typeent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_typeent' => 'Id Typeent',
			'typeent_code' => 'Typeent Code',
			'typeent_name' => 'Typeent Name',
			'typeent_description' => 'Typeent Description',
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

		$criteria->compare('id_typeent',$this->id_typeent);
		$criteria->compare('typeent_code',$this->typeent_code,true);
		$criteria->compare('typeent_name',$this->typeent_name,true);
		$criteria->compare('typeent_description',$this->typeent_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeEntity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
