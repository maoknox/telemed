<?php

/**
 * This is the model class for table "magnitude".
 *
 * The followings are the available columns in table 'magnitude':
 * @property integer $id_magnitude
 * @property string $magnitude_code
 * @property string $magnitude_name
 * @property string $magnitude_description
 *
 * The followings are the available model relations:
 * @property MagnitudeEntdev[] $magnitudeEntdevs
 */
class Magnitude extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'magnitude';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('magnitude_code', 'length', 'max'=>5),
			array('magnitude_name', 'length', 'max'=>50),
			array('magnitude_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_magnitude, magnitude_code, magnitude_name, magnitude_description', 'safe', 'on'=>'search'),
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
			'magnitudeEntdevs' => array(self::HAS_MANY, 'MagnitudeEntdev', 'id_magnitude'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_magnitude' => 'Id Magnitude',
			'magnitude_code' => 'Magnitude Code',
			'magnitude_name' => 'Magnitude Name',
			'magnitude_description' => 'Magnitude Description',
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

		$criteria->compare('id_magnitude',$this->id_magnitude);
		$criteria->compare('magnitude_code',$this->magnitude_code,true);
		$criteria->compare('magnitude_name',$this->magnitude_name,true);
		$criteria->compare('magnitude_description',$this->magnitude_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Magnitude the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
