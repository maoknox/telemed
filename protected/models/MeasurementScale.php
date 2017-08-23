<?php

/**
 * This is the model class for table "measurement_scale".
 *
 * The followings are the available columns in table 'measurement_scale':
 * @property integer $id_measscale
 * @property string $measscale_code
 * @property string $measscale_name
 * @property string $measscale_unity
 */
class MeasurementScale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'measurement_scale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('measscale_code, measscale_name, measscale_unity', 'required'),
			array('measscale_code, measscale_name', 'length', 'max'=>50),
			array('measscale_unity', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_measscale, measscale_code, measscale_name, measscale_unity', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_measscale' => 'Id Measscale',
			'measscale_code' => 'Measscale Code',
			'measscale_name' => 'Measscale Name',
			'measscale_unity' => 'Measscale Unity',
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

		$criteria->compare('id_measscale',$this->id_measscale);
		$criteria->compare('measscale_code',$this->measscale_code,true);
		$criteria->compare('measscale_name',$this->measscale_name,true);
		$criteria->compare('measscale_unity',$this->measscale_unity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MeasurementScale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
