<?php

/**
 * This is the model class for table "entity".
 *
 * The followings are the available columns in table 'entity':
 * @property integer $id_entity
 * @property integer $id_typeent
 * @property string $entity_number
 * @property string $entity_name
 * @property string $entity_lastname
 * @property string $entity_address
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property Contract[] $contracts
 * @property Person[] $people
 * @property Servicio[] $servicios
 * @property EntityDevice[] $entityDevices
 * @property TypeEntity $idTypeent
 * @property Telephone[] $telephones
 */
class Entity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_typeent, entity_number, entity_name, entity_address', 'required'),
                        array('entity_lastname', 'required','on'=>"lastname"),
			array('id_typeent', 'numerical', 'integerOnly'=>true),
			array('entity_number', 'length', 'max'=>1000),
			array('entity_name, entity_lastname', 'length', 'max'=>100),
			array('entity_address', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entity, id_typeent, entity_number, entity_name, entity_lastname, entity_address', 'safe', 'on'=>'search'),
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
			'cities' => array(self::MANY_MANY, 'City', 'city_entity(id_entity, id_city)'),
			'contracts' => array(self::HAS_MANY, 'Contract', 'id_entity'),
			'people' => array(self::MANY_MANY, 'Person', 'entity_person(id_entity, id_person)'),
			'servicios' => array(self::MANY_MANY, 'Servicio', 'entity_servicio(id_entity, id_servicio)'),
			'entityDevices' => array(self::HAS_MANY, 'EntityDevice', 'id_entity'),
			'idTypeent' => array(self::BELONGS_TO, 'TypeEntity', 'id_typeent'),
			'telephones' => array(self::HAS_MANY, 'Telephone', 'id_entity'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_entity' => 'Id Entity',
			'id_typeent' => 'Id Typeent',
			'entity_number' => 'Entity Number',
			'entity_name' => 'Entity Name',
			'entity_lastname' => 'Entity Lastname',
			'entity_address' => 'Entity Address',
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

		$criteria->compare('id_entity',$this->id_entity);
		$criteria->compare('id_typeent',$this->id_typeent);
		$criteria->compare('entity_number',$this->entity_number,true);
		$criteria->compare('entity_name',$this->entity_name,true);
		$criteria->compare('entity_lastname',$this->entity_lastname,true);
		$criteria->compare('entity_address',$this->entity_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchState($idCountry){
            $connect=Yii::app()->db;
            $sql="select id_state,state_name from state where id_country=:idcountry order by id_state asc";
            $query=$connect->createCommand($sql);
            $query->bindParam(":idcountry", $idCountry);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
        public function searchCity($idState){
            try{
                $connect=Yii::app()->db;
                $sql="select id_city,city_name from city where id_state=:idstate order by id_city asc";
                $query=$connect->createCommand($sql);
                $query->bindParam(":idstate", $idState);
                $read=$query->query();
                $res=$read->readAll();
                $read->close();
                return $res;
            }
            catch(CDbException $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
        * Devuelve el listado de empresas.
        *
        * @param type $this->tituloCurso variable del modelo que guarda el string digitado en campo en vista beca.php
        *
        * @return $result array de títulos de grado
        */
        public function buscarEntity($stringentity){
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
        public function searchService($idEntity){
            $conn=Yii::app()->db;
            $sql="select sr.id_service,sr.service_name from entity as et "
                    . "left join entity_service as es on es.id_entity=et.id_entity "
                    . "left join service as sr on sr.id_service=es.id_service "
                    . "where et.id_entity=:idEntity and es.id_service is not null";
            $query=$conn->createCommand($sql);
            $query->bindParam(":idEntity", $idEntity);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
