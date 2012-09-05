<?php

/**
 * This is the model class for table "tbl_user_class".
 *
 * The followings are the available columns in table 'tbl_user_class':
 * @property integer $student_id
 * @property integer $teacher_id
 * @property integer $class_id
 */
class LibUserClass extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LibUserClass the static model class
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
		return 'tbl_user_class';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, teacher_id, class_id', 'required'),
			array('student_id, teacher_id, class_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('student_id, teacher_id, class_id', 'safe', 'on'=>'search'),
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
			'student_id' => 'Student',
			'teacher_id' => 'Teacher',
			'class_id' => 'Class',
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

		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('teacher_id',$this->teacher_id);
		$criteria->compare('class_id',$this->class_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}