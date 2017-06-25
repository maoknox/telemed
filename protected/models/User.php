<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id_user
 * @property integer $id_person
 * @property integer $id_role
 * @property string $username
 * @property string $password
 * @property integer $user_active
 * @property string $user_allowed_ip
 * @property string $user_time_start
 * @property string $user_time_end
 *
 * The followings are the available model relations:
 * @property AuthAssignment[] $authAssignments
 * @property Role $idRole
 * @property Person $idPerson
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $confirmPassword;
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_person, id_role, username, password, user_active', 'required'),
			array('id_person, id_role, user_active', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>100),
			array('user_allowed_ip', 'length', 'max'=>50),
			array('user_time_start, user_time_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_user, id_person, id_role, username, password, user_active, user_allowed_ip, user_time_start, user_time_end, confirmPassword', 'safe', 'on'=>'search'),
                        array('password','confirmPassword'),
                        array('username','confirmUsername'),
                    
                );
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si la clave digitada coincide con el campo de verificación de clave.
	 */
	public function confirmUsername(){
		if(Yii::app()->controller->action->id=="registerplatform"){
                    $paramsUser=Yii::app()->request->getPost("User");
                    if(isset($paramsUser["username"])){
                        $modelUser=  User::model()->findByAttributes(array("username"=>$paramsUser["username"]));
                        if(!empty($modelUser)){
                                $this->addError('username',"El nombre de usuario digitado ya se encuentra registrado, intente otro.");
                        }
                    }	
		}
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si la clave digitada coincide con el campo de verificación de clave.
	 */
	public function confirmPassword(){
		if(Yii::app()->controller->action->id=="registerplatform"){
                    $paramsUser=Yii::app()->request->getPost("User");
			if(isset($paramsUser["password"])){
                            if($this->password!=$paramsUser["confirmPassword"]){
                                    $this->addError('password',"El password no coincide con la confirmación");
                            }elseif(strlen($this->password) < 6){
				  $this->addError('password',"La clave debe tener al menso seis carácteres");
			   }elseif(strlen($this->password) > 16){
				  $this->addError('password',"La clave no puede tener mas de 16 carácteres");
			   }elseif (!preg_match('`[a-z]`',$this->password)){
				  $this->addError('password',"La clave debe tener al menos una letra minúscula");
			   }elseif (!preg_match('`[A-Z]`',$this->password)){
				  $this->addError('password',"La clave debe tener al menos una letra mayúscula");
			   }elseif (!preg_match('`[0-9]`',$this->password)){
				  $this->addError('password',"La clave debe tener al menos un caracter numérico");
			   }
			}	
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
			'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'userid'),
			'idRole' => array(self::BELONGS_TO, 'Role', 'id_role'),
			'idPerson' => array(self::BELONGS_TO, 'Person', 'id_person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'Id User',
			'id_person' => 'Id Person',
			'id_role' => 'Id Role',
			'username' => 'Username',
			'password' => 'Password',
			'user_active' => 'User Active',
			'user_allowed_ip' => 'User Allowed Ip',
			'user_time_start' => 'User Time Start',
			'user_time_end' => 'User Time End',
                        'confirmPassword'=>'Confirm password'
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_person',$this->id_person);
		$criteria->compare('id_role',$this->id_role);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_active',$this->user_active);
		$criteria->compare('user_allowed_ip',$this->user_allowed_ip,true);
		$criteria->compare('user_time_start',$this->user_time_start,true);
		$criteria->compare('user_time_end',$this->user_time_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
