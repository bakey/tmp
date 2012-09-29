<?php

class StatisticsController extends Controller
{

	private function getXAxis( $problems )
	{
		$xCategories = array();
		foreach( $problems as $problem )
		{
			$xCategories[] = $problem->id;
		}
		$xAxis = array( 'categories' => $xCategories );
		return $xAxis;		
	}
	private function getYAxis()
	{
		return array(
				'title' => array(
						'text' => '错题人数',
						),
				);
	}
	private function is_wrong( $sid , $pid , $tid )
	{
		$user_task_problem_record = UserTaskProblemRecord::model()->findByAttributes( array(
					'user'    => $sid,
					'problem' => $pid,
					'task'    => $tid,
				) 
		);
		if ( null == $user_task_problem_record )
		{
			throw new CHttpException( 404 , "目前还没有考试记录");
		}
		$ans_wrong = $user_task_problem_record->check_ans;
		return !$ans_wrong;
		
	}
	private function getStudentSeries( $class_model , $task_id , $problems )
	{
		$students = $class_model->class_student;
		$ret = array(
				'name' => $class_model->name,
				'data' => array(),
				);
		foreach ( $problems as $problem )
		{
			$pid = $problem->id;
			foreach( $students as $student )
			{
				$wrong_cnt = 0;
				if ( $this->is_wrong( $student->id , $pid , $task_id ) )
				{
					++ $wrong_cnt;					
				}
			}
			$ret['data'][] = $wrong_cnt;
		}
		return $ret;	
	}
	/*
	 * 获取某班学生的某次考试的错题率
	* @return highchart 所需的options数组。
	*   'options'=>array(
			*       'title' => array('text' => 'Fruit Consumption'),
			*       'xAxis' => array(
					*          'categories' => array('Apples', 'Bananas', 'Oranges')
					*       ),
			*       'yAxis' => array(
					*          'title' => array('text' => 'Fruit eaten')
					*       ),
			*       'series' => array(
					*          array('name' => 'Jane', 'data' => array(1, 0, 4)),
					*          array('name' => 'John', 'data' => array(5, 7, 3))
					*       )
			*    )
	*/
	private function getStudentWrongRate( $task_id , $class_ids )
	{
		$task_model = Task::model()->findByPk( $task_id );
		if ( null == $task_model ) {
			return null;
		}
		//$class_model = LibClass::model()->findByPk( $class_id );
		$options = array(
				'title' => array('text' => '错题人数统计'),
				'xAxis' => array(),
				'yAxis' => array(),
				'series' => array(),
			);
		$problems = $task_model->problems;
		$options['xAxis'] = $this->getXAxis( $problems );
		$options['yAxis'] = $this->getYAxis();
		foreach( $class_ids as $class_id ) 
		{
			$class_model = LibClass::model()->findByPk( $class_id );
			$options['series'][] = $this->getStudentSeries( $class_model , $task_id , $problems );		
		}	
		return $options;
	}
	private function renderTeacherStat( $task_id )
	{
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );
		$all_class = $user_model->teacher_class;
		$class_ids = array();
		foreach( $all_class as $libclass )
		{
			$class_ids[] = $libclass->id; 
		}
		$this->render('stat' , array(
				'options' => $this->getStudentWrongRate( $task_id , $class_ids ),
		));
		
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionGetTaskStat( $task_id )
	{	
		if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] )
		{
			$this->renderTeacherStat( $task_id );
		}
		else {
			$this->render('index');
		}	
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}