<?php

/**
 * This is the model class for table "typeobject_service".
 *
 * The followings are the available columns in table 'typeobject_service':
 * @property integer $id_typeobjservice
 * @property integer $id_typeobject
 * @property integer $id_service
 *
 * The followings are the available model relations:
 * @property Object[] $objects
 * @property Service $idService
 * @property TypeObject $idTypeobject
 */
class TypeobjectService extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'typeobject_service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_typeobject, id_service', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_typeobjservice, id_typeobject, id_service', 'safe', 'on'=>'search'),
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
			'objects' => array(self::HAS_MANY, 'Object', 'id_typeobjservice'),
			'idService' => array(self::BELONGS_TO, 'Service', 'id_service'),
			'idTypeobject' => array(self::BELONGS_TO, 'TypeObject', 'id_typeobject'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_typeobjservice' => 'Id Typeobjservice',
			'id_typeobject' => 'Id Typeobject',
			'id_service' => 'Id Service',
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

		$criteria->compare('id_typeobjservice',$this->id_typeobjservice);
		$criteria->compare('id_typeobject',$this->id_typeobject);
		$criteria->compare('id_service',$this->id_service);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeobjectService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
