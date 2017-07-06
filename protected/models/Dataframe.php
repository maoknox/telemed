<?php

/**
 * This is the model class for table "dataframe".
 *
 * The followings are the available columns in table 'dataframe':
 * @property integer $id_dataframe
 * @property integer $id_entdev
 * @property string $dataframe
 * @property string $dataframe_date
 *
 * The followings are the available model relations:
 * @property EntityDevice $idEntdev
 */
class Dataframe extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $time="";
	public function tableName()
	{
		return 'dataframe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_entdev, dataframe, dataframe_date', 'required'),
			array('id_entdev', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dataframe, id_entdev, dataframe, dataframe_date', 'safe', 'on'=>'search'),
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
			'idEntdev' => array(self::BELONGS_TO, 'EntityDevice', 'id_entdev'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dataframe' => 'Id Dataframe',
			'id_entdev' => 'Id Entdev',
			'dataframe' => 'Dataframe',
			'dataframe_date' => 'Dataframe Date',
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

		$criteria->compare('id_dataframe',$this->id_dataframe);
		$criteria->compare('id_entdev',$this->id_entdev);
		$criteria->compare('dataframe',$this->dataframe,true);
		$criteria->compare('dataframe_date',$this->dataframe_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dataframe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchGeoposition($positionDF,$geoLatLong,$idEntDev){
            $latLong="";
            $positionMag="";
            if(!empty($positionDF)){
                foreach($positionDF as $position){
                    if($position["magnitude_code"]==$geoLatLong){
                        $positionMag=$position["position_dataframe"];
                    }
                }
                $criteria = new CDbCriteria;
                $criteria->condition = 'id_entdev=:identdev';
                $criteria->order='dataframe_date DESC';
                $criteria->limit = 1;
                $criteria->params = array(':identdev' => $idEntDev);
                $dataFrame=$this->find($criteria);
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $this->time=$dataFrame->dataframe_date;
                $latLong=$dataFramesArr[3+$positionMag];
            }
            return $latLong;
        }
}
