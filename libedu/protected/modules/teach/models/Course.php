<?php

/**
 * This is the model class for table "tbl_course".
 *
 * The followings are the available columns in table 'tbl_course':
 * @property integer $id
 * @property integer $edition_id
 * @property string $name
 * @property string $description
 * @property integer $view_count
 */
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return 'tbl_course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('edition_id, view_count', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, edition_id, name, description, view_count', 'safe', 'on'=>'search'),
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
				'edition'=>array(self::BELONGS_TO , 'CourseEdition','edition_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'edition_id'  => 'Edition',	
			'name'        => 'Name',
			'description' => 'Description',
			'view_count'  => 'View Count',
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
		$criteria->compare('edition_id',$this->edition_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('view_count',$this->view_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getCourseTeacher()
	{
		if ( !isset($this->id) )
		{
			return null;
		}
		$user_course_model = UserCourse::model()->find( 'course_id=:cid and role=:role' , array( 'cid' => $this->id , 
																				 ':role' => Yii::app()->params['user_role_teacher']) );
		if ( null != $user_course_model ) 
		{
			$teacher_id = $user_course_model->user_id;
			return LibUser::model()->findByPk( $teacher_id );
		}
		else
		{
			return null;
		}
	}
	public function getCourseStudentCount()
	{
		if ( !isset($this->id) )
		{
			return null;
		}
		return UserCourse::model()->count( 'course_id=:cid and role=:role' , 
				array( ':cid' => $this->id ,
						':role' => Yii::app()->params['user_role_student']) );
	}
	public function getCourseStudentsModel()
	{
		if ( !isset($this->id) )
		{
			return null;
		}
		$user_courses = UserCourse::model()->findAll( 'course_id=:cid and role=:role' , 
				array( ':cid' => $this->id , 
						':role' => Yii::app()->params['user_role_student']) );
		$user_model = array();
		foreach( $user_courses as $uc )
		{
			$user_model[] = LibUser::model()->findByPk( $uc->user_id );			
		}
		return $user_model;		
	}
	public function getCourseSubject()
	{
		return $this->subject;
	}
}