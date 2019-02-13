<?php

/**
 * This is the model class for table "role_user".
 *
 * The followings are the available columns in table 'role_user':
 * @property integer $id_role
 * @property integer $id_user
 * @property string $ru_time_start
 * @property string $ru_time_end
 * @property integer $ru_active
 * @property string $ru_allowed_ip
 */
class RoleUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_role, id_user', 'required'),
			array('id_role, id_user, ru_active', 'numerical', 'integerOnly'=>true),
			array('ru_allowed_ip', 'length', 'max'=>50),
			array('ru_time_start, ru_time_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_role, id_user, ru_time_start, ru_time_end, ru_active, ru_allowed_ip', 'safe', 'on'=>'search'),
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
			'id_role' => 'Id Role',
			'id_user' => 'Id User',
			'ru_time_start' => 'Ru Time Start',
			'ru_time_end' => 'Ru Time End',
			'ru_active' => 'Ru Active',
			'ru_allowed_ip' => 'Ru Allowed Ip',
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

		$criteria->compare('id_role',$this->id_role);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('ru_time_start',$this->ru_time_start,true);
		$criteria->compare('ru_time_end',$this->ru_time_end,true);
		$criteria->compare('ru_active',$this->ru_active);
		$criteria->compare('ru_allowed_ip',$this->ru_allowed_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoleUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
