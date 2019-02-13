<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property string $id_device
 * @property integer $id_type_device
 * @property integer $id_statedevice
 * @property string $device_name
 * @property string $device_description
 * @property integer $device_associated
 *
 * The followings are the available model relations:
 * @property EntityDevice[] $entityDevices
 * @property TypeDevice $idTypeDevice
 * @property StateDevice $idStatedevice
 * @property Service[] $services
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
			array('id_device, id_type_device, id_statedevice', 'required'),
			array('device_associated', 'required','on'=>'new'),
			array('id_type_device, id_statedevice, device_associated', 'numerical', 'integerOnly'=>true),
			array('id_device, device_name', 'length', 'max'=>50),
			array('device_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_device, id_type_device, id_statedevice, device_name, device_description, device_associated', 'safe', 'on'=>'search'),
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
			'entityDevices' => array(self::HAS_MANY, 'EntityDevice', 'id_device'),
			'idTypeDevice' => array(self::BELONGS_TO, 'TypeDevice', 'id_type_device'),
			'idStatedevice' => array(self::BELONGS_TO, 'StateDevice', 'id_statedevice'),
			'services' => array(self::MANY_MANY, 'Service', 'service_device(id_device, id_service)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_device' => 'Id Device',
			'id_type_device' => 'Id Type Device',
			'id_statedevice' => 'Id Statedevice',
			'device_name' => 'Device Name',
			'device_description' => 'Device Description',
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
		$criteria->compare('id_type_device',$this->id_type_device);
		$criteria->compare('id_statedevice',$this->id_statedevice);
		$criteria->compare('device_name',$this->device_name,true);
		$criteria->compare('device_description',$this->device_description,true);
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
        /**
	 * Consulta los dispositivos que no están asociados y que estan en buen estado.
	 * @param int $idService $stateDev int $assoc.
	 * @return ide de dispositivo $res
	 */
        public function searchDevice($idService,$stateDev,$assoc){
            $conn=Yii::app()->db;
            $sql="select dev.id_device "
                    . "from device as dev "
                    . "left join service_device as sd on sd.id_device=dev.id_device "
                    . "left join state_device as std on std.id_statedevice=dev.id_statedevice "
                    . "where sd.id_service=:idService and std.statedevice_code=:code and device_associated=:assoc ";
            $query=$conn->createCommand($sql);
            $query->bindParam(":idService",$idService);
            $query->bindParam(":code",$stateDev);
            $query->bindParam(":assoc",$assoc);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
        public function searchDeviceAll(){
            $conn=Yii::app()->db;
            $sql="select * from device as dev "
                    . "left join type_device as td on td.id_type_device=dev.id_type_device "
                    . "left join state_device as sd on sd.id_statedevice=dev.id_statedevice";
            $query=$conn->createCommand($sql);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
