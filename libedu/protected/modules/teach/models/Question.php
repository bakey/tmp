<?php

/**
 * This is the model class for table "tbl_question".
 *
 * The followings are the available columns in table 'tbl_question':
 * @property integer $id
 * @property integer $owner
 * @property integer $item
 * @property string $details
 * @property string $create_time
 * @property integer $view_count
 */
class Question extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item,details', 'required'),
			array('owner, item, view_count', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner, item, details, create_time, view_count', 'safe', 'on'=>'search'),
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
			'owner_info'=>array(self::BELONGS_TO,'LibUser','owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner' => 'Owner',
			'item' => 'Item',
			'details' => 'Details',
			'create_time' => 'Create Time',
			'view_count' => 'Viewcount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('item',$this->item);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('view_count',$this->view_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function beforeSave(){
		if ($this->isNewRecord){
			$this->owner = Yii::app()->user->id;
			$this->create_time = date("Y-m-d H:i:s");
			$this->view_count = 0;
		}
		return parent::beforeSave();
	}

	public function afterSave(){
		$kpToSave = ItemKp::model()->findAllByAttributes(array('item'=>$this->item));
		foreach($kpToSave as $singlekp){
			$qkp = new QuestionKp;
			$qkp->question = $this->id;
			$qkp->knowledge_point = $singlekp->knowledge_point;
			$qkp->save();	
		}
	}
}