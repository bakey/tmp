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
			return null;
		}
		$ans_wrong = $user_task_problem_record->check_ans;
		return !$ans_wrong;		
	}
	/*
	 * 获取该班所有的学生在这个task中的考试记录。
	 */
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
			//求出对于某个问题这个班的学生的错误数量
			$wrong_cnt = 0;
			foreach( $students as $student )
			{
				$task_ret = $this->is_wrong( $student->id , $pid , $task_id );
				if ( null == $task_ret ) {
					continue;
				}
				if ( $task_ret )
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
		//横轴坐标是这个任务的所有问题
		$options['xAxis'] = $this->getXAxis( $problems );
		//纵轴可以根据实际数据调整，在这里是错题的人数
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
		if ( LibUser::is_teacher() ) 
		{			 
			$tasks = Task::model()->findAll( 'author=:uid and status=:stat_publish' , array(
											  			':uid'=>Yii::app()->user->id , 
											  			':stat_publish' => Task::STATUS_PUBLISHED )  );
			$show_data = array();
			foreach( $tasks as $task )
			{
				$total_records = TaskRecord::model()->findAll( 'task=:tid ' , array(':tid'=>$task->id) );
				$total_join_task_cnt = count($total_records );
				$finish_task_cnt = 0;
				foreach( $total_records as $record )
				{
					if ( $record->status == TaskRecord::TASK_STATUS_FINISHED )
					{
						++ $finish_task_cnt;
					}
				}
				$show_data[] = array(
						'total_join_task_cnt' => $total_join_task_cnt,
						'finish_task_cnt'     => $finish_task_cnt,
						'create_time'         => $task->create_time,
						'author'              => $task->author,
						'name'                => $task->name,
						'status'			  => $task->status,
						'item'                => $task->item,
						'id'				  => $task->id,
						);			
				
			}
			
			$this->render('teacher_stat_index' , 
					array( 'teacher_index_data' => new CArrayDataProvider($show_data) ) );
		}
		else 
		{
			$this->render('student_stat_index' );
		}
	}
	public function actionGetTaskStat( $task_id )
	{	
		if ( LibUser::is_teacher() )
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