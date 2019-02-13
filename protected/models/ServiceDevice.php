<?php

/**
 * This is the model class for table "service_device".
 *
 * The followings are the available columns in table 'service_device':
 * @property string $id_device
 * @property integer $id_service
 */
class ServiceDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_device, id_service', 'required'),
			array('id_service', 'numerical', 'integerOnly'=>true,'on'=>'register'),
			array('id_device', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_device, id_service', 'safe', 'on'=>'search'),
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
			'id_device' => 'Id Device',
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

		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_service',$this->id_service);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceDevice the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
        
        public function searchServiceDevice($devices){
            if(!empty($devices)){
                $conn=Yii::app()->db;
                $sql="select s.id_service,s.service_name from service as s left join service_device as sd on sd.id_service=s.id_service where sd.id_device=:iddevice";
                foreach($devices as $pk=>$device){
                    $query=$conn->createCommand($sql);
                    $query->bindParam(":iddevice", $device["id_device"]);
                    $read=$query->query();
                    $res=$read->readAll();
                    $read->close();
                    $devices[$pk]["services"]=$res;
                }
                return $devices;
            }
            else{
                return $service=array();
            }
        }
}
