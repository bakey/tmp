<?php

/**
 * This is the model class for table "tbl_user_school".
 *
 * The followings are the available columns in table 'tbl_user_school':
 * @property integer $user_id
 * @property integer $school_id
 * @property string $school_unique_id
 * @property integer $role
 */
class UserSchool extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSchool the static model class
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
		return 'tbl_user_school';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, school_id, school_unique_id, role', 'required'),
			array('user_id, school_id, role', 'numerical', 'integerOnly'=>true),
			array('school_unique_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, school_id, school_unique_id, role', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'school_id' => 'School',
			'school_unique_id' => 'School Unique',
			'role' => 'Role',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('school_unique_id',$this->school_unique_id,true);
		$criteria->compare('role',$this->role);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}