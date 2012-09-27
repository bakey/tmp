<?php

/**
 * This is the model class for table "tbl_task_record".
 *
 * The followings are the available columns in table 'tbl_task_record':
 * @property integer $task
 * @property integer $accepter
 * @property string $start_time
 * @property string $end_time
 * @property integer $score
 * @property integer $status
 */
class TaskRecord extends CActiveRecord
{
	const TASK_STATUS_UNFINISHED = 0;
	const TASK_STATUS_FINISHED   = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @return TaskRecord the static model class
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
		return 'tbl_task_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task, accepter, score, status', 'numerical', 'integerOnly'=>true),
			array('start_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('task, accepter, start_time, end_time, score, status', 'safe', 'on'=>'search'),
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
			'task' => 'Task',
			'accepter' => 'Accepter',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'score' => 'Score',
			'status' => 'Status',
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

		$criteria->compare('task',$this->task);
		$criteria->compare('accepter',$this->accepter);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}