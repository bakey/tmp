<?php

/**
 * This is the model class for table "tbl_user_task_problem_record".
 *
 * The followings are the available columns in table 'tbl_user_task_problem_record':
 * @property integer $record_id
 * @property integer $user
 * @property integer $task
 * @property integer $problem
 * @property string $ans
 * @property integer $check_ans
 */
class UserTaskProblemRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserTaskProblemRecord the static model class
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
		return 'tbl_user_task_problem_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, user, task, problem, ans', 'required'),
			array('record_id, user, task, problem, check_ans', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('record_id, user, task, problem, ans, check_ans', 'safe', 'on'=>'search'),
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
			'record_id' => 'Record',
			'user' => 'User',
			'task' => 'Task',
			'problem' => 'Problem',
			'ans' => 'Ans',
			'check_ans' => 'Check Ans',
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

		$criteria->compare('record_id',$this->record_id);
		$criteria->compare('user',$this->user);
		$criteria->compare('task',$this->task);
		$criteria->compare('problem',$this->problem);
		$criteria->compare('ans',$this->ans,true);
		$criteria->compare('check_ans',$this->check_ans);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}