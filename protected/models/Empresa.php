<?php

/**
 * This is the model class for table "empresa".
 *
 * The followings are the available columns in table 'empresa':
 * @property integer $id_empresa
 * @property integer $id_municipio
 * @property integer $id_tipoempresa
 * @property string $nit_empresa
 * @property string $nombre_empresa
 * @property string $direccion_empresa
 * @property string $email_empresa
 *
 * The followings are the available model relations:
 * @property Municipio $idMunicipio
 * @property TipoEmpresa $idTipoempresa
 * @property MedidorSuscriptor[] $medidorSuscriptors
 */
class Empresa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'empresa';
	}
        public function getDbConnection(){
            return Yii::app()->dbi; // or return Yii::app()->db2;
        }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_municipio, id_tipoempresa, nit_empresa', 'required'),
			array('id_municipio, id_tipoempresa', 'numerical', 'integerOnly'=>true),
			array('nit_empresa', 'length', 'max'=>15),
			array('nombre_empresa', 'length', 'max'=>100),
			array('direccion_empresa', 'length', 'max'=>1000),
			array('email_empresa', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_empresa, id_municipio, id_tipoempresa, nit_empresa, nombre_empresa, direccion_empresa, email_empresa', 'safe', 'on'=>'search'),
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
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idTipoempresa' => array(self::BELONGS_TO, 'TipoEmpresa', 'id_tipoempresa'),
			'medidorSuscriptors' => array(self::HAS_MANY, 'MedidorSuscriptor', 'id_empresa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_empresa' => 'Id Empresa',
			'id_municipio' => 'Id Municipio',
			'id_tipoempresa' => 'Id Tipoempresa',
			'nit_empresa' => 'Nit Empresa',
			'nombre_empresa' => 'Nombre Empresa',
			'direccion_empresa' => 'Direccion Empresa',
			'email_empresa' => 'Email Empresa',
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

		$criteria->compare('id_empresa',$this->id_empresa);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_tipoempresa',$this->id_tipoempresa);
		$criteria->compare('nit_empresa',$this->nit_empresa,true);
		$criteria->compare('nombre_empresa',$this->nombre_empresa,true);
		$criteria->compare('direccion_empresa',$this->direccion_empresa,true);
		$criteria->compare('email_empresa',$this->email_empresa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empresa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
