<?php

/**
 * This is the model class for table "magnitude_entdev".
 *
 * The followings are the available columns in table 'magnitude_entdev':
 * @property integer $id_entdev
 * @property integer $id_magnitude
 * @property integer $id_meassystem
 * @property integer $serialid_sensor
 * @property integer $min_magnitude
 * @property integer $max_magnitude
 * @property integer $position_dataframe
 */
class MagnitudeEntdev extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'magnitude_entdev';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_entdev, id_magnitude, position_dataframe', 'required'),
			array('id_entdev, id_magnitude, id_meassystem, serialid_sensor, min_magnitude, max_magnitude, position_dataframe', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entdev, id_magnitude, id_meassystem, serialid_sensor, min_magnitude, max_magnitude, position_dataframe', 'safe', 'on'=>'search'),
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
			'id_entdev' => 'Id Entdev',
			'id_magnitude' => 'Id Magnitude',
			'id_meassystem' => 'Id Meassystem',
			'serialid_sensor' => 'Serialid Sensor',
			'min_magnitude' => 'Min Magnitude',
			'max_magnitude' => 'Max Magnitude',
			'position_dataframe' => 'Position Dataframe',
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

		$criteria->compare('id_entdev',$this->id_entdev);
		$criteria->compare('id_magnitude',$this->id_magnitude);
		$criteria->compare('id_meassystem',$this->id_meassystem);
		$criteria->compare('serialid_sensor',$this->serialid_sensor);
		$criteria->compare('min_magnitude',$this->min_magnitude);
		$criteria->compare('max_magnitude',$this->max_magnitude);
		$criteria->compare('position_dataframe',$this->position_dataframe);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MagnitudeEntdev the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchMagnitudesByObject($idEntDev){
            $conn=Yii::app()->db;
            $sql="select me.position_dataframe,me.min_magnitude,me.max_magnitude,mag.magnitude_name,ms.meassystem_spanish from magnitude_entdev as me "
                    . "left join magnitude as mag on mag.id_magnitude=me.id_magnitude "
                    . "left join measurement_system as ms on ms.id_meassystem=me.id_meassystem "
                    . "where me.id_entdev=:idEntDev "
                    . "order by me.position_dataframe asc";
            $query=$conn->createCommand($sql);
            $query->bindParam(":idEntDev", $idEntDev);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
