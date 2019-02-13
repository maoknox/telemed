<?php

/**
 * This is the model class for table "historico_consumo".
 *
 * The followings are the available columns in table 'historico_consumo':
 * @property integer $id_historicoconsumo
 * @property integer $id_lecturaactual
 * @property integer $orden_histconsumo
 * @property string $historico_consumo
 *
 * The followings are the available model relations:
 * @property LecturaActual $idLecturaactual
 */
class HistoricoConsumo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'historico_consumo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden_histconsumo, historico_consumo', 'required'),
			array('id_lecturaactual, orden_histconsumo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_historicoconsumo, id_lecturaactual, orden_histconsumo, historico_consumo', 'safe', 'on'=>'search'),
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
			'idLecturaactual' => array(self::BELONGS_TO, 'LecturaActual', 'id_lecturaactual'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_historicoconsumo' => 'Id Historicoconsumo',
			'id_lecturaactual' => 'Id Lecturaactual',
			'orden_histconsumo' => 'Orden Histconsumo',
			'historico_consumo' => 'Historico Consumo',
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

		$criteria->compare('id_historicoconsumo',$this->id_historicoconsumo);
		$criteria->compare('id_lecturaactual',$this->id_lecturaactual);
		$criteria->compare('orden_histconsumo',$this->orden_histconsumo);
		$criteria->compare('historico_consumo',$this->historico_consumo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoricoConsumo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
