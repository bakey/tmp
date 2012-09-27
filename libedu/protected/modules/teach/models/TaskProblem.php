<?php

/**
 * This is the model class for table "tbl_task_problem".
 *
 * The followings are the available columns in table 'tbl_task_problem':
 * @property integer $task_id
 * @property integer $problem_id
 * @property integer $problem_score
 */
class TaskProblem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TaskProblem the static model class
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
		return 'tbl_task_problem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id, problem_id, problem_score', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('task_id, problem_id, problem_score', 'safe', 'on'=>'search'),
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
			'task'=>array(self::BELONGS_TO,'Task','task_id'),
			'problem'=>array(self::BELONGS_TO,'Problem','problem_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => 'Task',
			'problem_id' => 'Problem',
			'problem_score' => 'Problem Score',
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

		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('problem_id',$this->problem_id);
		$criteria->compare('problem_score',$this->problem_score);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}