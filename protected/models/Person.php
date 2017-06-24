<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property integer $id_person
 * @property integer $id_typedocument
 * @property string $person_numberid
 * @property string $person_name
 * @property string $person_lastname
 * @property string $person_email
 *
 * The followings are the available model relations:
 * @property Entity[] $entities
 * @property TypeDocument $idTypedocument
 * @property User[] $users
 */
class Person extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_typedocument, person_numberid, person_name, person_lastname, person_email', 'required'),
			array('id_typedocument', 'numerical', 'integerOnly'=>true),
			array('person_numberid, person_name, person_lastname, person_email', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_person, id_typedocument, person_numberid, person_name, person_lastname, person_email', 'safe', 'on'=>'search'),
                        array('person_email', 'UniqueAttributesValidator'),
		);
	}
        
        /*
         * Validar correo único
         */
        public function UniqueAttributesValidator($attribute,$params){
            $email=$this->findByAttributes(array('person_email'=>$this->person_email));
            if(!empty($email)){
            $this->addError($attribute, 'El email ya se encuentra registrado');
            
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'entities' => array(self::MANY_MANY, 'Entity', 'entity_person(id_person, id_entity)'),
			'idTypedocument' => array(self::BELONGS_TO, 'TypeDocument', 'id_typedocument'),
			'users' => array(self::HAS_MANY, 'User', 'id_person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_person' => 'Id Person',
			'id_typedocument' => 'Id Typedocument',
			'person_numberid' => 'Person Numberid',
			'person_name' => 'Person Name',
			'person_lastname' => 'Person Lastname',
			'person_email' => 'Person Email',
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

		$criteria->compare('id_person',$this->id_person);
		$criteria->compare('id_typedocument',$this->id_typedocument);
		$criteria->compare('person_numberid',$this->person_numberid,true);
		$criteria->compare('person_name',$this->person_name,true);
		$criteria->compare('person_lastname',$this->person_lastname,true);
		$criteria->compare('person_email',$this->person_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
