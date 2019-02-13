<?php

/**
 * This is the model class for table "municipio".
 *
 * The followings are the available columns in table 'municipio':
 * @property integer $id_municipio
 * @property integer $id_departamento
 * @property string $idvar_municipio
 * @property string $nombre_municipio
 *
 * The followings are the available model relations:
 * @property Empresa[] $empresas
 * @property MedidorSuscriptor[] $medidorSuscriptors
 * @property Departamento $idDepartamento
 * @property SuscriptorUsuario[] $suscriptorUsuarios
 */
class Municipio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'municipio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_departamento, idvar_municipio, nombre_municipio', 'required'),
			array('id_departamento', 'numerical', 'integerOnly'=>true),
			array('idvar_municipio', 'length', 'max'=>5),
			array('nombre_municipio', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_municipio, id_departamento, idvar_municipio, nombre_municipio', 'safe', 'on'=>'search'),
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
			'empresas' => array(self::HAS_MANY, 'Empresa', 'id_municipio'),
			'medidorSuscriptors' => array(self::HAS_MANY, 'MedidorSuscriptor', 'id_municipio'),
			'idDepartamento' => array(self::BELONGS_TO, 'Departamento', 'id_departamento'),
			'suscriptorUsuarios' => array(self::HAS_MANY, 'SuscriptorUsuario', 'id_municipio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_municipio' => 'Id Municipio',
			'id_departamento' => 'Id Departamento',
			'idvar_municipio' => 'Idvar Municipio',
			'nombre_municipio' => 'Nombre Municipio',
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

		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('idvar_municipio',$this->idvar_municipio,true);
		$criteria->compare('nombre_municipio',$this->nombre_municipio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Municipio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getDbConnection(){
            return Yii::app()->dbi; // or return Yii::app()->db2;
        }
}
