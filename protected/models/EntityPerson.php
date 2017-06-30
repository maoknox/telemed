<?php

/**
 * This is the model class for table "entity_person".
 *
 * The followings are the available columns in table 'entity_person':
 * @property integer $id_entity
 * @property integer $id_person
 */
class EntityPerson extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity_person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_entity, id_person', 'required'),
			array('id_entity, id_person', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entity, id_person', 'safe', 'on'=>'search'),
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
			'id_entity' => 'Id Entity',
			'id_person' => 'Id Person',
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
		$criteria->compare('id_person',$this->id_person);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EntityPerson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * Returns an array with entity's services from id_user variable.
	 * @param string $idPerson .
	 * @return $res aray
	 */
        public function searchServiceByEntity(){
            $conn=Yii::app()->db;
            $sql="select sr.id_service,sr.service_name,sr.service_code from public.user as us "
                    . "left join entity_person as ep on ep.id_person=us.id_person "
                    . "left join entity as et on et.id_entity=ep.id_entity "
                    . "left join entity_service as se on se.id_entity=et.id_entity "
                    . "left join service as sr on sr.id_service=se.id_service "
                    . "where us.username=:username";
            $query=$conn->createCommand($sql);
            $username=Yii::app()->user->getId();
            $query->bindParam(":username",$username);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            return $res;
        }
        
}
