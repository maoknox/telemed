<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $id_service
 * @property string $service_name
 * @property string $service_code
 *
 * The followings are the available model relations:
 * @property Device[] $devices
 * @property Entity[] $entities
 * @property Geozoneg[] $geozonegs
 * @property TypeobjectService[] $typeobjectServices
 */
class Service extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_name, service_code', 'required'),
			array('service_name, service_code', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_service, service_name, service_code', 'safe', 'on'=>'search'),
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
			'devices' => array(self::HAS_MANY, 'Device', 'id_service'),
			'entities' => array(self::MANY_MANY, 'Entity', 'entity_service(id_service, id_entity)'),
			'geozonegs' => array(self::HAS_MANY, 'Geozoneg', 'id_service'),
			'typeobjectServices' => array(self::HAS_MANY, 'TypeobjectService', 'id_service'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_service' => 'Id Service',
			'service_name' => 'Service Name',
			'service_code' => 'Service Code',
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

		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('service_code',$this->service_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchServiceByUsername($username){
            $conn=Yii::app()->db;
            $sql="select sr.id_service,sr.service_name,sr.service_code from public.user as usr "
                    . "left join person as pr on pr.id_person=usr.id_person "
                    . "left join entity_person as ep on ep.id_person=pr.id_person "
                    . "left join entity_service as es on es.id_entity=ep.id_entity "
                    . "left join service as sr on sr.id_service=es.id_service "
                    . "where username=:username;";
            $query=$conn->createCommand($sql);
            $query->bindParam(":username", $username);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
}
