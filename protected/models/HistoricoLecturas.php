<?php

/**
 * This is the model class for table "historico_lecturas".
 *
 * The followings are the available columns in table 'historico_lecturas':
 * @property integer $id_histlectura
 * @property integer $id_lecturaactual
 * @property integer $orden_histlectura
 * @property string $fecha_historicolect
 * @property string $historico_lectura
 *
 * The followings are the available model relations:
 * @property LecturaActual $idLecturaactual
 */
class HistoricoLecturas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'historico_lecturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden_histlectura', 'required'),
			array('id_lecturaactual, orden_histlectura', 'numerical', 'integerOnly'=>true),
			array('fecha_historicolect, historico_lectura', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_histlectura, id_lecturaactual, orden_histlectura, fecha_historicolect, historico_lectura', 'safe', 'on'=>'search'),
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
			'id_histlectura' => 'Id Histlectura',
			'id_lecturaactual' => 'Id Lecturaactual',
			'orden_histlectura' => 'Orden Histlectura',
			'fecha_historicolect' => 'Fecha Historicolect',
			'historico_lectura' => 'Historico Lectura',
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

		$criteria->compare('id_histlectura',$this->id_histlectura);
		$criteria->compare('id_lecturaactual',$this->id_lecturaactual);
		$criteria->compare('orden_histlectura',$this->orden_histlectura);
		$criteria->compare('fecha_historicolect',$this->fecha_historicolect,true);
		$criteria->compare('historico_lectura',$this->historico_lectura,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoricoLecturas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
