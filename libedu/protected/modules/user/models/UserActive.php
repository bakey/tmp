<?php

/**
 * This is the model class for table "tbl_user_active".
 *
 * The followings are the available columns in table 'tbl_user_active':
 * @property integer $school_id
 * @property string $school_unique_id
 * @property integer $class_id
 * @property string $name
 * @property integer $grade
 * @property string $active_id
 * @property string $create_time
 */
class UserActive extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserActive the static model class
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
		return 'tbl_user_active';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('school_id, active_id, create_time', 'required'),
			array('school_id, class_id, grade', 'numerical', 'integerOnly'=>true),
			array('school_unique_id, name, active_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('school_id, school_unique_id, class_id, name, grade, active_id, create_time', 'safe', 'on'=>'search'),
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
			'school_id' => 'School',
			'school_unique_id' => 'School Unique',
			'class_id' => 'Class',
			'name' => 'Name',
			'grade' => 'Grade',
			'active_id' => 'Active',
			'create_time' => 'Create Time',
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

		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('school_unique_id',$this->school_unique_id,true);
		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('active_id',$this->active_id,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}