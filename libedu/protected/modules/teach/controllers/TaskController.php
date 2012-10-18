<?php

class TaskController extends Controller
{
	const TASK_STATUS_DRAFT = 0;
	const TASK_STATUS_PUBLISH = 1;
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/online_column';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','topics'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','index','showfinishtask','ajaxcheckanswer','test','publishtask','previewtask','filterproblem','viewtopics','ajaxloadkp','ajaxloaditem','create','update','topics','createTaskProblem','addExaminee','addTaskRecord','participateTask','createTaskRecord'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	private function create_task_knowledgepoint( $task_model )
	{
		$selected_kp = $_POST['Task']['kp'];
		foreach( $selected_kp as $kp )
		{
			$task_kp_model = new TaskKp;
			$task_kp_model->task = $task_model->id;
			$task_kp_model->kp = $kp;
			$task_kp_model->save();
		}
		return true;
	}
	private function create_new_task( $task_model )
	{
		$task_model->status = task::STATUS_DRAFT ;
		$task_model->attributes = $_POST['Task'];
		if ( !$task_model->save() ) {
			throw new CHttpException( 500 , "创建测试记录失败");
		}
		$problem_selected = $_POST['problem_selected'];
		foreach( $problem_selected as $selected )
		{
			$task_problem_model = new TaskProblem;
			$task_problem_model->task_id = $task_model->id ;
			$task_problem_model->problem_id = (int) $selected ;
			$task_problem_model->problem_score = 0 ;
			$task_problem_model->save();
		}
		return $this->create_task_knowledgepoint( $task_model );		
	}
	private function preview_task()
	{
		
	}
	private function check_task_exist( $task_id )
	{
		return Task::model()->exists('id=' . $task_id );
	}
	private function check_task_record_exist( $task_id )
	{
		return TaskRecord::model()->exists('task=' . $task_id );
	}
	private function updateTaskRecord( $task_id , $task_accepter )
	{
		$task_rec_model = TaskRecord::model()->find( 'task=:tid and accepter=:uid' , 
					array( ':tid'=>$task_id , 
							':uid' => $task_accepter ) );
		if ( null != $task_rec_model ) {
			$task_rec_model->status = TaskRecord::TASK_STATUS_FINISHED;
			$task_rec_model->save();
			return $task_rec_model;
		}
		return null ;		
	}
	private function recordTaskProblemStatus( $rec_id , $problem_info , $task , $user )
	{
		foreach ( $problem_info as $info )
		{
			$task_problem_rec = new UserTaskProblemRecord;
			$task_problem_rec->record_id = $rec_id;
			$task_problem_rec->user      = $user;
			$task_problem_rec->task      = $task;
			$task_problem_rec->problem   = $info['id'];
			$task_problem_rec->ans       = $info['user_ans'];
			$task_problem_rec->check_ans = $info['check_ans'];
			$task_problem_rec->save();
		}		
	}
	private function updateTaskStatus( $task_id , $status )
	{
		$task_model = Task::model()->findByPk( $task_id );
		if ( null != $task_model ) {
			$task_model->status = $status;
			return $task_model->save();
		}else {
			return false;
		}
	}
	private function getFinishTaskStuCnt( $task_id )
	{
		return TaskRecord::model()->count( 'task=:tid and status=:status', array( ':tid' => $task_id , ':status' => TaskRecord::TASK_STATUS_FINISHED ) );		
	}
	private  function getTotalAcceptTaskStuCnt( $task_id )
	{
		return TaskRecord::model()->count( 'task=:tid', array( ':tid' => $task_id ) );	
	}
	private function getTaskInfoData( $teacher )
	{
		$tasks = $teacher->task_as_teacher;
		$dataProvider = new CArrayDataProvider( $tasks , array(
				'sort'=>array(
						'attributes'=>array(
								'item DESC',
						),
						'defaultOrder' => 'create_time DESC',
				),
			)
		);
		$task_data = array();
		foreach( $dataProvider->getData() as $data )
		{
			$task_info = array();
			//如果测验已经发布，那么获取完成测试的学生数量
			if ( $data->status == Task::STATUS_PUBLISHED ) {
				$task_info['finish_task_stu_cnt'] = $this->getFinishTaskStuCnt( $data->id );
				$task_info['total_accept_task_stu_cnt'] = $this->getTotalAcceptTaskStuCnt( $data->id );	
			}
			$task_info['id']   = $data->id;
			$task_info['item'] = $data->item;
			$task_info['name'] = $data->name;
			$task_info['author'] = $data->author;
			$task_info['create_time'] = $data->create_time;
			$task_info['status'] = $data->status;
			//获取task其他数据
			$task_data[] = $task_info;
		} 
		$array_task_data = new CArrayDataProvider( $task_data );
		return $array_task_data ;		
	}
	
	public function actionTest()
	{
		/*$dataProvider = new CActiveDataProvider( 'Problem' );
		if ( isset( $_POST['select_ans']) )
		{
			var_dump( $_POST );
			exit();
		}
		$this->render('test' , array(
						'problem_data'=>$dataProvider ,
						));*/
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$task_record_data = new CActiveDataProvider( 'TaskRecord' , array(
				'criteria'=>array(
						'condition'=>'task=' . $id ,
				),				
		));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'task_record_model' => $task_record_data,
		));
	}
	public function actionPreviewTask( $task_id )
	{
		$task_model = Task::model()->findByPk( $task_id );
		if ( null == $task_model ) {
			throw new CHttpException( 404 , "no this task ");
		}
		//获取该老师当前课程的所有学生
		$user_course_model = UserCourse::model()->findAll( 'role=:role and course_id=:course_id',
					array(
						':role'      =>Yii::app()->params['user_role_student'],
						':course_id' =>Yii::app()->user->course,							
					) );
		$student_models = array();
		foreach( $user_course_model as $uc )
		{
			$user_model = LibUser::model()->findByPk( $uc->user_id );
			$student_models[] = $user_model;
		}
		$student_data = new CArrayDataProvider( $student_models );
		$problems = $task_model->problems;
		$problem_data = array();
		foreach( $problems as $problem )
		{
			$problem_data[] = array( 'id'         => $problem->id , 
									  'content'    =>$problem->content,
									  'difficulty' => $problem->getDifficulty(),
									  'type'       => $problem->getType(),
					);
		}
		$problemDataProvider = new CArrayDataProvider( $problem_data );
		$this->render( 'preview',array(
									'problem_data'    => $problemDataProvider ,
									'task_id' 	      => $task_id,
									'student_data'    => $student_data,
				) );	
	}
	public function actionPublishTask( $task_id )
	{
		$course = Yii::app()->user->course;
		
		if ( !$this->check_task_exist( $task_id ) ){
			throw new CHttpException( 404 , "没有这个测验");
		}
		if ( $this->check_task_record_exist( $task_id) ) {
			//本次测试已经发布，不需要重新发布了。
			$task_record_data = new CActiveDataProvider( 'TaskRecord' , array(
					'criteria'=>array(
							'condition'=>'task=:task_id',
							'params'=>array(':task_id'=>$task_id),
					),
			));
			$this->render('publish_task' , array(
					'task_record_model'=>$task_record_data,
					'new_record'=>0,
					) );
			return ;
		}
		if ( !isset($_POST['publish-student-form_c2']) )
		{
			throw new CHttpException( 500 , "需要指定学生来发布测试");			
		}
		$student_id_arr = $_POST['publish-student-form_c2'];
		
		foreach( $student_id_arr as $sid )
		{
			//建立task record的关联
			$task_record_model = new TaskRecord;
			$task_record_model->task = $task_id;
			$task_record_model->accepter = $sid;
			$task_record_model->status = TaskRecord::TASK_STATUS_UNFINISHED;
			$task_record_model->save();
		}	
		$task_record_data = new CActiveDataProvider( 'TaskRecord' , array(
				'criteria'=>array(
						'condition'=>'task=:task_id',
						'params'=>array(':task_id'=>$task_id),
					), 
				));
		$this->updateTaskStatus( $task_id , Task::STATUS_PUBLISHED );
		$this->render('publish_task' , array(
						'task_record_model'=>$task_record_data,
						'new_record'=>1,
				) );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$task_model    = new Task;
		$dataProvider  = new CActiveDataProvider('Problem');
		
		if( isset($_POST['Task']) )
		{			
			if ( isset( $_POST['publish']) || isset($_POST['preview']) ) {
				//把task model存好，并把task_problem,task_knowledge_point都关联好
				if ( $this->create_new_task( $task_model ) ) {
					$this->redirect( array("previewtask" , 'task_id'=>$task_model->id) ) ;
				}else {
					throw new CHttpException(500 , "发布测验失败");
				}
			}
			else {
				throw  new CHttpException( 404 , "未知的测验请求");
			}
		}

		$this->render('create_task',array(
			'task_model'=>$task_model,
			'problem_data' => $dataProvider,
		));
	}
	public function actionViewTopics($id)
	{
		$taskProblem=new CActiveDataProvider('TaskProblem',array(
				'pagination'=>array(
						'pagesize'=>10),
				'criteria'=>array(
						'condition'=>'task_id=:task_id',
						'params'=>array(':task_id'=>$id),
				),
		));
		$problem_data = $taskProblem->getData();
		$problems = array();
		for( $i=0 ; $i < count($problem_data) ; $i++ )
		{
			$criteria=new CDbCriteria;
			$criteria->compare('id',$problem_data[$i]->problem_id);
			$problems[$i] = Problem::model()->findAll($criteria);
		}
		$this->render('viewTopics',array(
				'data'=>$problems,
				'id'=>$id));
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = null;
		$condition = "";
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );
		if ( LibUser::is_teacher() ) 
		{
			$this->render('teacher_task_index',array(
					'dataProvider'=>$this->getTaskInfoData( $user_model ),
			));
		}
		else if ( LibUser::is_student() )
		{
			$tasks = $user_model->task_as_student;
			$finished_tasks = $unfinished_tasks = array();
			foreach( $tasks as $task )
			{
				$task_rec = TaskRecord::model()->find(
						'task=:tid and accepter=:uid and status=:status',
						array(
							':tid' => $task->id,
							':uid' => $user_model->id,
							':status' => TaskRecord::TASK_STATUS_UNFINISHED , 
							  )
						);
				$info = array(
						'item' => $task->item,
						'name'    => $task->name,
						'id'      => $task->id,
						'author' => $task->author,
						'create_time' => $task->create_time,
						);
				if ( null == $task_rec ) {
					$info['status'] = TaskRecord::TASK_STATUS_FINISHED;
					$finished_tasks[] = $info ;
				} else {
					$info['status'] = TaskRecord::TASK_STATUS_UNFINISHED ;
					$unfinished_tasks[] = $info ;
				}
			}
			$finished_task_data = new CArrayDataProvider( $finished_tasks ,
					array( 'sort'=>array(
							'defaultOrder' => 'create_time DESC',))
					);
			$unfinished_tasks = new CArrayDataProvider( $unfinished_tasks , array( 'sort'=>array(
							'defaultOrder' => 'create_time DESC',)));
			$this->render('studetn_task_index',array(
					'finished_task_data'   => $finished_task_data,
					'unfinished_task_data' => $unfinished_tasks,
			));
		}
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Task('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Task']))
			$model->attributes=$_GET['Task'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
    
	 /*添加题目
	   */
    public function actionFilterProblem()
	{
		$criteria=new CDbCriteria;
		if ( isset($_POST['problem_type']) ) {
			$criteria->compare('type',$_POST['problem_type']);			
		}
		if ( isset($_POST['difficulty_level']) ) {
			$criteria->compare('difficulty',$_POST['difficulty_level']);			
		}
		if ( isset( $_POST['subject']) ) {
			$criteria->compare('subject' , $_POST['subject'] );
		}
		$sort_type = isset( $_POST['sort_type']) ? $_POST['sort_type'] : null;
		
		$dataProvider = null;
  
        if( null != $sort_type && $sort_type == 0 )
		{
			$dataProvider=new CActiveDataProvider('Problem',array(
				'criteria'=>$criteria,
			    'sort'=>array(
					'defaultOrder'=>'t.create_time DESC',),
					'pagination'=>array(
					'pageSize'=>5),
				));
		}
		else if( null != $sort_type && $sort_type == 1 )
		{
            $dataProvider=new CActiveDataProvider('Problem',array(
				'criteria'=>$criteria,
			    'sort'=>array(
					'defaultOrder'=>'t.use_count DESC',),
					'pagination'=>array(
						'pageSize'=>5),
				));
		}
		else {
			$dataProvider=new CActiveDataProvider('Problem',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>5),
			));
			
		}
		$this->renderPartial('problem_list',
					array(
							'problem_data'=>$dataProvider,));
	}

    /*创建一条测试记录
	 */
    public function actionCreateTaskRecord()
	{	
		$taskid=$_POST['taskid'];
        $dataProvider=new CActiveDataProvider('TaskProblem',array(
			'pagination'=>array(
				'pagesize'=>10),
			'criteria'=>array(
				'condition'=>'task_id=:task_id',
				'params'=>array(':task_id'=>$taskid),
			),
		 ));
		
        $criteria=new CDbCriteria;
		$criteria->compare('id',$taskid);
		$task=Task::model()->findAll($criteria);
    
		$data=$dataProvider->getData();
        $problems=array();	
		for($i=0;$i<count($data);$i++)
		{
			$criteria=new CDbCriteria;
		    $criteria->compare('id',$data[$i]->problem_id);
			$problems[$i]=Problem::model()->findAll($criteria);
		}

		$criteriaTaskRecord=new CDbCriteria;
		$criteriaTaskRecord->compare('accepter',Yii::app()->user->id);
		$criteriaTaskRecord->compare('task',$taskid);
		$taskRecord=TaskRecord::model()->find($criteriaTaskRecord);
		$taskRecord->start_time=date('Y-m-d H:i:s',time());
		$lasttime=explode(":",$task[0]->last_time);
		$time=0;
		if(strncasecmp($lasttime[0],"00",2))
		{
			$time=$time+intval($lasttime[0]*60*60);
		}
		if(strncasecmp($lasttime[1],"00",2))
		{
			$time=$time+intval($lasttime[1]*60);
		}
		if(strncasecmp($lasttime[2],"00",2))
		{
			$time=$time+intval($lasttime[2]);
		}
		$taskRecord->end_time=date('Y-m-d H:i:s',time()+$time);

		for($j=0;$j<count($problems);$j++)
		{
			$check=$_POST[strval($problems[$j][0]->id)];
		  
		    $answers='';
		    if($problems[$j][0]->type==0)
			{
				$index=strval($problems[$j][0]->id);
				$answers=$_POST[strval($problems[$j][0]->id)];
			}
			else if($problems[$j][0]->type==1)
			{
				$check=$_POST[strval($problems[$j][0]->id)];
			
				$answers='';
			  for($i=0;$i<count($check);$i++)
			    {
					$answers=$answers.$check[$i];
			    }
			}
			if(strcasecmp($answers,$problems[$j][0]->references_ans)==0)
			{
				$taskRecord->score+=$data[$j]->problem_score;
			}
		}
		$taskRecord->status=1;
		$taskRecord->save();
	}

	public function actionAddTaskRecord()
	{	
        $criteria=new CDbCriteria;
		$criteria->compare('receiver',Yii::app()->user->id);
		$criteria->compare('type',Notification::TEST);
		$notification=new CActiveDataProvider('Notification',array(
			'criteria'=>$criteria,));
		$notificationModel=$notification->getData();
		
        $this->render('addTaskRecord',array(
			'model'=>$notificationModel,));		
	}

    public function actionParticipateTask( $task_id )
	{
		$task_model = Task::model()->findByPk( $task_id );
		$problem_models = $task_model->problems;
		$dataProvider = new CArrayDataProvider( $problem_models );
		$this->render('participatetask' , array(
				'problem_data'=>$dataProvider ,
				'task_id' => $task_id,
		));
	}
	public function actionShowFinishTask( $task_id )
	{
		$uid = Yii::app()->user->id;
		$task_problem_record_model = UserTaskProblemRecord::model()->findAll(
					'task=:tid and user=:uid',
					array(	
							':tid' => $task_id ,
							':uid' => $uid, 
						  )
				);
		$problem_data = array();
		foreach( $task_problem_record_model as $single_item )
		{
			$pid = $single_item->problem;
			$problem_model = Problem::model()->findByPk( $pid );
			$problem_data[] =  array(
					'check_ans' => $single_item->check_ans,
					'id'        => $problem_model->id,
					'source'    => $problem_model->source,
					'content'   => $problem_model->content,
					'select_ans'=> $problem_model->select_ans,
					'user_ans'	=> $single_item->ans,					
					);			
		}
		$dataProvider = new CArrayDataProvider( $problem_data );
		$this->render( 'viewfinishedtask' , array(
				'problem_data' => $dataProvider,
				) );
		
	}
	public function actionAjaxCheckAnswer( $task_id )
	{
		$uid = Yii::app()->user->id;
		if ( TaskRecord::model()->exists( 'task=:tid and accepter=:uid and status=1' , array( ':tid'=>$task_id , ':uid'=>$uid )) )
		{
			echo("task finished!!");
			return ;			
		}
		if ( isset( $_POST['select_ans']) )
		{
			$check_ret = array();
			$problem_info = array();
			foreach( $_POST['select_ans'] as $problem_id=>$user_ans )
			{
				$problem_model = Problem::model()->findByPk( $problem_id );
				$ans = chr( $user_ans+ord('A') );
				$ref_ans = $problem_model->reference_ans;
				$check_ans = 0;
		
				if ( $ans == $ref_ans ) {
					$check_ret[] = array( $problem_id => 1 );
					$check_ans = 1;
				}else {
					$check_ret[] = array( $problem_id => 0 );
					$check_ans = 0;
				}
				$problem_info[] = array(
						'id' => $problem_id,
						'user_ans' => $ans,
						'check_ans' => $check_ans, 
						);
			}
			$rec = $this->updateTaskRecord( $task_id , $uid );
			$this->recordTaskProblemStatus( $rec->id , $problem_info , $task_id , $uid ); 
			echo json_encode( $check_ret );
		}		
	}
	public function actionAjaxLoadkp()
	{
		$level_cond = "";
		$parent_id = null;
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parent_id = (int) $_GET['root'];
				$level_cond = " level > 1 " ;
			}else {
				//第一层查询
				$level_cond = " level <=> 1 ";
			}
		}
		$children = array();
		$kps = KnowledgePoint::model()->findAll(
				$level_cond
		);
		foreach( $kps as $it )
		{
			$info = array() ;
			$parent = $it->kp_parent ;
			if ( count($it->kp_child) > 0 ) {
				$info['hasChildren'] = 1;
			}else {
				$info['hasChildren'] = 0;
			}
			$info['text'] = $it->name;
			$info['id']	= $it->id;
			if ( null == $parent_id ) {
				$children[] = $info;
			}else if ( count($parent) > 0 && $parent[0]->id == $parent_id ) {
				$children[] = $info;
			}
		}
		
		$treedata=array();
		foreach($children as $child){
			$select_kp_js = sprintf('select_kp(%d);',$child['id']);
			$options=array(
					'href'=>'javascript:void(0)',
					'id'=>"kp_".$child['id'],
					'class'=>'treenode',
					'onclick' => $select_kp_js ,
			);
			$nodeText = CHtml::openTag('a', $options);
			$nodeText .= $child['text'];
			$nodeText .= CHtml::closeTag('a')."\n";
			$child['text'] = $nodeText;
			$treedata[]=$child;
		}
		
		echo str_replace(
				'"hasChildren":"0"',
				'"hasChildren":false',
				CTreeView::saveDataAsJson($treedata)
		);
		
	}
	public function actionAjaxLoadItem()
	{
		// accept only AJAX request (comment this when debugging)
		/*if (!Yii::app()->request->isAjaxRequest) {
		 exit();
		}*/
		// parse the user input
		$parentId = null ;
		$edition_id = null ;
		$course_model = Course::model()->findByPk( Yii::app()->user->course );
		if ( null != $course_model ) {
			$edition_id = $course_model->edition_id;
		}
		$levelCondition = "";

		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parentId = (int) $_GET['root'];
				$levelCondition = " level > 1 " ;
			}else {
				//第一层查询
				$levelCondition = " level <=> 1 ";
			}
		}
		$condition = "edition=:edition ";
		if ( $parentId != null ) {
			$condition .= "and level > 1 ";
		}
		else {
			$condition .= "and level = 1 ";
		}
		$children = array();
		$items = Item::model()->findAll(
				$condition,
				array( ':edition'=>$edition_id )
		);
		foreach( $items as $it )
		{
			$info = array() ;
			$parent = $it->level_parent ;
			if ( count($it->level_child) > 0 ) {
				$info['hasChildren'] = 1;
			}else {
				$info['hasChildren'] = 0;
			}
			$info['text'] = $it->content;
			$info['id']	= $it->id;
			if ( $parentId == null ) {
				$children[] = $info;
			}else if ( count($parent) > 0 && $parent[0]->id == $parentId ) {
				$children[] = $info;
			}
		}
	
		/*
		 * 我们期望或得到类似" id content hasChildren"排列的数据，通过json方式返回给ajax调用，
		* 前端接收到后根据这个信息渲染出树状结构。
		*/
		//$sql_cmd = sprintf("SELECT %s.id, %s.content AS text, max(%s.id<=>%s.parent) AS hasChildren FROM %s join %s where %s.edition <=> %s ",
		//	self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , $editionId );
	
	
	
	
		// read the data (this could be in a model)
		//$children = Yii::app()->db->createCommand( $sql_cmd )->queryAll();
	
	
		$treedata=array();
		foreach($children as $child){
			$select_item_js = sprintf('select_item(%d);',$child['id']);
			$options=array(
						'href'=>'#',
						'id'=>$child['id'],
						'class'=>'treenode',
						'onclick' => $select_item_js,
				);
			$nodeText = CHtml::openTag('a', $options);
			$nodeText .= $child['text'];
			$nodeText.= CHtml::closeTag('a')."\n";
			$child['text'] = $nodeText;
			$treedata[]=$child;
		}
		//var_dump( $treedata );
		//exit();
	
		echo str_replace(
				'"hasChildren":"0"',
				'"hasChildren":false',
				CTreeView::saveDataAsJson($treedata)
				//CTreeView::saveDataAsJson($children)
		);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Task::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='task-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
