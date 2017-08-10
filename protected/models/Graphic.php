<?php

/**
 * This is the model class for table "graphic".
 *
 * The followings are the available columns in table 'graphic':
 * @property integer $id_graphic
 * @property string $graphic_name
 * @property string $graphic_code
 *
 * The followings are the available model relations:
 * @property Magnitude[] $magnitudes
 */
class Graphic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'graphic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('graphic_name, graphic_code', 'required'),
			array('graphic_name, graphic_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_graphic, graphic_name, graphic_code', 'safe', 'on'=>'search'),
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
			'magnitudes' => array(self::MANY_MANY, 'Magnitude', 'magnitude_graphic(id_graphic, id_magnitude)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_graphic' => 'Id Graphic',
			'graphic_name' => 'Graphic Name',
			'graphic_code' => 'Graphic Code',
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

		$criteria->compare('id_graphic',$this->id_graphic);
		$criteria->compare('graphic_name',$this->graphic_name,true);
		$criteria->compare('graphic_code',$this->graphic_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Graphic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
