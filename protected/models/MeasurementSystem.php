<?php

/**
 * This is the model class for table "measurement_system".
 *
 * The followings are the available columns in table 'measurement_system':
 * @property integer $id_meassystem
 * @property string $meassystem_code
 * @property string $meassystem_spanish
 * @property string $meassystem_english
 * @property string $meassystem_description
 *
 * The followings are the available model relations:
 * @property MagnitudeEntdev[] $magnitudeEntdevs
 */
class MeasurementSystem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'measurement_system';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('meassystem_code, meassystem_spanish, meassystem_english, meassystem_description', 'required'),
			array('meassystem_code', 'length', 'max'=>3),
			array('meassystem_spanish, meassystem_english', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_meassystem, meassystem_code, meassystem_spanish, meassystem_english, meassystem_description', 'safe', 'on'=>'search'),
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
			'magnitudeEntdevs' => array(self::HAS_MANY, 'MagnitudeEntdev', 'id_meassystem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_meassystem' => 'Id Meassystem',
			'meassystem_code' => 'Meassystem Code',
			'meassystem_spanish' => 'Meassystem Spanish',
			'meassystem_english' => 'Meassystem English',
			'meassystem_description' => 'Meassystem Description',
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

		$criteria->compare('id_meassystem',$this->id_meassystem);
		$criteria->compare('meassystem_code',$this->meassystem_code,true);
		$criteria->compare('meassystem_spanish',$this->meassystem_spanish,true);
		$criteria->compare('meassystem_english',$this->meassystem_english,true);
		$criteria->compare('meassystem_description',$this->meassystem_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MeasurementSystem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
