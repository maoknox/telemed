<?php

/**
 * This is the model class for table "entity_device".
 *
 * The followings are the available columns in table 'entity_device':
 * @property integer $id_entdev
 * @property string $id_device
 * @property integer $id_city
 * @property integer $id_service
 * @property integer $id_entity
 * @property integer $serialid_object
 * @property integer $entdev_anchorage
 *
 * The followings are the available model relations:
 * @property Command[] $commands
 * @property Dataframe[] $dataframes
 * @property Geozoneg[] $geozonegs
 * @property Device $idDevice
 * @property Object $serialidObject
 * @property City $idCity
 * @property Entity $idEntity
 * @property Service $idService
 * @property Magnitude[] $magnitudes
 */
class EntityDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity_device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_device, id_entity, serialid_object', 'required'),
			array('id_city, id_service, id_entity, serialid_object, entdev_anchorage', 'numerical', 'integerOnly'=>true),
			array('id_device', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entdev, id_device, id_city, id_service, id_entity, serialid_object, entdev_anchorage', 'safe', 'on'=>'search'),
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
			'commands' => array(self::MANY_MANY, 'Command', 'command_entdev(id_entdev, id_command)'),
			'dataframes' => array(self::HAS_MANY, 'Dataframe', 'id_entdev'),
			'geozonegs' => array(self::MANY_MANY, 'Geozoneg', 'entitydevice_geozone(id_entdev, id_geozoneg)'),
			'idDevice' => array(self::BELONGS_TO, 'Device', 'id_device'),
			'serialidObject' => array(self::BELONGS_TO, 'Object', 'serialid_object'),
			'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
			'idEntity' => array(self::BELONGS_TO, 'Entity', 'id_entity'),
			'idService' => array(self::BELONGS_TO, 'Service', 'id_service'),
			'magnitudes' => array(self::MANY_MANY, 'Magnitude', 'magnitude_entdev(id_entdev, id_magnitude)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_entdev' => 'Id Entdev',
			'id_device' => 'Id Device',
			'id_city' => 'Id City',
			'id_service' => 'Id Service',
			'id_entity' => 'Id Entity',
			'serialid_object' => 'Serialid Object',
			'entdev_anchorage' => 'Entdev Anchorage',
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
		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_city',$this->id_city);
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('id_entity',$this->id_entity);
		$criteria->compare('serialid_object',$this->serialid_object);
		$criteria->compare('entdev_anchorage',$this->entdev_anchorage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EntityDevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
        * Devuelve el listado de empresas.
        *
        * @param type $this->tituloCurso variable del modelo que guarda el string digitado en campo en vista beca.php
        *
        * @return $result array de títulos de grado
        */
        public function searchObject($stringObject){
            $conect= Yii::app()->db;
            $entity=  strtolower($stringentity);
            $sql="SELECT * FROM entity WHERE (entity_number LIKE :param1)
                or (lower(entity_number) LIKE :param2)
                or (lower(entity_number) LIKE :param3)
                or (lower(entity_number) LIKE :param4)
                or (lower(entity_name) LIKE :param5)
                or (lower(entity_name) LIKE :param6)
                or (lower(entity_name) LIKE :param7)
                or (lower(entity_name) LIKE :param8)order by entity_name asc";
            $query=$conect->createCommand($sql);
            $param1='%%'.$entity.'%%';
            $param2='%%'.$entity;
            $param3=$entity.'%%';
            $query->bindParam(':param1',$param1,PDO::PARAM_STR);
            $query->bindParam(':param2',$param2,PDO::PARAM_STR);
            $query->bindParam(':param3',$param3,PDO::PARAM_STR);
            $query->bindParam(':param4',$entity,PDO::PARAM_STR);
            $query->bindParam(':param5',$param1,PDO::PARAM_STR);
            $query->bindParam(':param6',$param2,PDO::PARAM_STR);
            $query->bindParam(':param7',$param3,PDO::PARAM_STR);
            $query->bindParam(':param8',$entity,PDO::PARAM_STR);
            $read=$query->query();
            $result=$read->readAll();
            $read->close();			
            return $result;
        }
        
        public function searchAllObjects(){
            $connect=Yii::app()->db;
            $sql="select * from object as ob "
            ."left join entity_device as ed on ed.serialid_object=ob.serialid_object "
            ."left join device as dv on dv.id_device=ed.id_device "
            ."left join service as sv on sv.id_service=ed.id_service "
            ."left join entity as et on et.id_entity=ed.id_entity";
            $query=$connect->createCommand($sql);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
        public function searchObjectsById($idEntDev){
            $connect=Yii::app()->db;
            $sql="select * from object as ob "
            ."left join entity_device as ed on ed.serialid_object=ob.serialid_object "
            ."left join device as dv on dv.id_device=ed.id_device "
            ."left join service as sv on sv.id_service=ed.id_service "
            ."left join entity as et on et.id_entity=ed.id_entity "
            . "where ed.id_entdev=:identdev";
            $query=$connect->createCommand($sql);
            $query->bindParam(":identdev",$idEntDev);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
