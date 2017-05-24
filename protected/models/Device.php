<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property string $id_device
 * @property integer $id_service
 * @property integer $id_type_device
 * @property integer $id_statedevice
 * @property integer $device_associated
 *
 * The followings are the available model relations:
 * @property TypeDevice $idTypeDevice
 * @property Service $idService
 * @property StateDevice $idStatedevice
 * @property EntityDevice[] $entityDevices
 */
class Device extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_device, device_associated', 'required'),
			array('id_service, id_type_device, id_statedevice, device_associated', 'numerical', 'integerOnly'=>true),
			array('id_device', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_device, id_service, id_type_device, id_statedevice, device_associated', 'safe', 'on'=>'search'),
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
			'idTypeDevice' => array(self::BELONGS_TO, 'TypeDevice', 'id_type_device'),
			'idService' => array(self::BELONGS_TO, 'Service', 'id_service'),
			'idStatedevice' => array(self::BELONGS_TO, 'StateDevice', 'id_statedevice'),
			'entityDevices' => array(self::HAS_MANY, 'EntityDevice', 'id_device'),
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
			'id_type_device' => 'Id Type Device',
			'id_statedevice' => 'Id Statedevice',
			'device_associated' => 'Device Associated',
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
		$criteria->compare('id_type_device',$this->id_type_device);
		$criteria->compare('id_statedevice',$this->id_statedevice);
		$criteria->compare('device_associated',$this->device_associated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchDevice($idService,$stateDev,$assoc){
            $conn=Yii::app()->db;
            $sql="select id_device from device as dev "
                    . "left join state_device as sd on sd.id_statedevice=dev.id_statedevice "
                    . "where dev.id_service=:idService "
                    . "and sd.statedevice_code=:code "
                    . "and device_associated=:assoc ";
            $query=$conn->createCommand($sql);
            $query->bindParam(":idService",$idService);
            $query->bindParam(":code",$stateDev);
            $query->bindParam(":assoc",$assoc);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
