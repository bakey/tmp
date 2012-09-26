<?php

/**
 * This is the model class for table "tbl_news".
 *
 * The followings are the available columns in table 'tbl_news':
 * @property integer $id
 * @property integer $user
 * @property integer $type
 * @property integer $resource_id
 * @property string $content
 * @property string $create_time
 * @property integer $school
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'tbl_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, type, resource_id, content, create_time, school', 'required'),
			array('user, type, resource_id, school', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user, type, resource_id, content, create_time, school', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'user' => 'User',
			'type' => 'Type',
			'resource_id' => 'Resource',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'school' => 'School',
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
		$criteria->compare('user',$this->user);
		$criteria->compare('type',$this->type);
		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('school',$this->school);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}