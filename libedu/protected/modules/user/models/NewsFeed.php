<?php

/**
 * This is the model class for table "tbl_news_feed".
 *
 * The followings are the available columns in table 'tbl_news_feed':
 * @property integer $id
 * @property integer $publisher
 * @property integer $receiver
 * @property integer $type
 * @property string $create_time
 * @property integer $resource_id
 * @property string $content
 */
class NewsFeed extends CActiveRecord
{
	const SYSTEM=0;
	const AUDIT=1;
	const QA=2;
	const TEST=3;
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewsFeed the static model class
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
		return 'tbl_news_feed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receiver, type, resource_id', 'numerical', 'integerOnly'=>true),
			array('create_time, content', 'safe'),
			array('receiver,content','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, publisher, receiver, type, create_time, resource_id, content', 'safe', 'on'=>'search'),
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
			'sender'=>array(self::BELONGS_TO,'LibUser','publisher'),
			'receiver'=>array(self::HAS_MANY,'LibUser','receiver'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'publisher' => 'Sender',
			'receiver' => 'Receiver',
			'type' => 'Notification Type',
			'create_time' => 'Create Time',
			'resource_id' => 'Resource',
			'content' => 'Content',
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
		$criteria->compare('publisher',$this->publisher);
		$criteria->compare('receiver',$this->receiver);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getTypeOptions()
	{
		return array(
			self::SYSTEM=>'System Notification',
			self::AUDIT=>'Audit Notification',
			self::QA=>'Questions and Answers',
			self::TEST=>'Test Notification',);
	}

	public function getTypeText()
	{
		$typeOptions=$this->typeOptions;
		return isset($typeOptions[$this->type])?
			$typeOptions[$this->type]:
			"Unknown type ({$this->type})";
	}

}