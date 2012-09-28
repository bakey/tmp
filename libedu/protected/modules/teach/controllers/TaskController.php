<?php

class TaskController extends Controller
{
	const TASK_STATUS_DRAFT = 0;
	const TASK_STATUS_PUBLISH = 1;
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/online_column';

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
				'actions'=>array('index','view','topics'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','ajaxcheckanswer','test','publishtask','previewtask','sortproblem','viewtopics','ajaxloadkp','ajaxloaditem','create','update','topics','createTaskProblem','addExaminee','examinee','addTaskRecord','participateTask','createTaskRecord'),
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
	private function create_task_problem( $task_model )
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
		return $this->create_task_problem( $task_model );		
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
		$problems = $task_model->problems;
		$problem_data = array();
		foreach( $problems as $problem )
		{
			$problem_data[] = array( 'id' => $problem->id , 
									  'content'=>$problem->content
					);
		}
		$dataProvider = new CArrayDataProvider( $problem_data );
		$this->render( 'preview',array(
					'problem_data' => $dataProvider ,
					'task_id' => $task_id,
				) );	
	}
	public function actionPublishTask( $task_id )
	{
		$course = Yii::app()->user->course;
		
		if ( !$this->check_task_exist( $task_id ) ){
			throw new CHttpException( 404 , "没有这个测验");
		}
		if ( $this->check_task_record_exist( $task_id) ) {
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
		
		$criteria=new CDbCriteria;
		$criteria->select='user_id'; 
		$criteria->condition='course_id=:course_id and role='.Yii::app()->params['user_role_teacher'];
		$criteria->params=array(':course_id'=>$course);
		
		$user_course_model = UserCourse::model()->findAll( $criteria );
		
		$task_record_set = array();
		foreach( $user_course_model as $one_model )
		{
			$task_record_model = new TaskRecord;
			$task_record_model->task = $task_id;
			$task_record_model->accepter = $one_model->user_id;
			$task_record_model->status = TaskRecord::TASK_STATUS_UNFINISHED;
			$task_record_model->save();
			$task_record_set[] = $task_record_model;
		}	
		$task_record_data = new CActiveDataProvider( 'TaskRecord' , array(
				'criteria'=>array(
						'condition'=>'task=:task_id',
						'params'=>array(':task_id'=>$task_id),
					), 
				));
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
		$dataProvider = new CActiveDataProvider('Problem');
		
		if( isset($_POST['Task']) )
		{
			
			if ( isset( $_POST['publish']) ) {
				if ( $this->create_new_task( $task_model ) ) {
					$this->redirect( array("previewtask" , 'task_id'=>$task_model->id) ) ;
				}else {
					throw new CHttpException(500 , "发布测验失败");
				}
			}
			else if ( isset($_POST['preview']) ) {
				$this->preview_task();
			}
		}

		$this->render('create',array(
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
		if ( null == $user_model ) {
			throw new CHttpException(500 , "获取用户失败");
		}
		if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) 
		{
			$tasks = $user_model->task_as_teacher;
			$dataProvider = new CArrayDataProvider( $tasks , array(
					'sort'=>array(
							'attributes'=>array(
									'item DESC',
							),
							'defaultOrder' => 'create_time DESC',
						),
					)
			);
		}
		else if ( Yii::app()->user->urole == Yii::app()->params['user_role_student'] )
		{
			$tasks = $user_model->task_as_student;
			$dataProvider = new CArrayDataProvider( $tasks );
		}
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
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
    public function actionSortProblem()
	{
		if(isset($_POST['typeid']) && isset($_POST['levelid']))
		{
			$type=$_POST['typeid'];
			$level=$_POST['levelid'];
			$criteria=new CDbCriteria;
			$criteria->compare('type',$type);
			$criteria->compare('difficulty',$level);
		}
		else if(isset($_POST['typeid']) && !isset($_POST['levelid']))
		{
			$type=$_POST['typeid'];
			$criteria=new CDbCriteria;
			$criteria->compare('type',$type);
		}
		else if(!isset($_POST['typeid']) && isset($_POST['levelid']))
		{
			$level=$_POST['levelid'];
			$criteria=new CDbCriteria;
			$criteria->compare('difficulty',$level);
		}
		else
		{
			$type='';
			$level='';
			$criteria=new CDbCriteria;
			$criteria->compare('type',$type);
			$criteria->compare('difficulty',$level);
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


	public function actionExaminee($taskid)
	{
		$select=$_POST['sel'];

        $criteria=new CDbCriteria;
		$criteria->compare('id',$taskid);
		$task=Task::model()->findAll($criteria);

		$i=0;
		while($i<count($select))
		{
			$notification=new Notification();
			$taskRecord=new TaskRecord();
			$taskRecord->accepter=intval($select[$i]);
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
			$taskRecord->task = $taskid;
			$taskRecord->status = TaskRecord::TASK_STATUS_UNFINISHED ;
			$taskRecord->save();
			$notification->publisher=Yii::app()->user->id;
			$notification->receiver=intval($select[$i]);
			$notification->type= Notification::TEST ;
			$notification->resource_id=intval($taskid);
			$notification->create_time=date('Y-m-d H:i:s',time());
			$notification->content=$_POST['content'];
			$i++;
			$notification->save();
		}
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
		));
	}
	public function actionAjaxCheckAnswer()
	{
		if ( isset( $_POST['select_ans']) )
		{
			$check_ret = array();
			foreach( $_POST['select_ans'] as $problem_id=>$user_ans )
			{
				$problem_model = Problem::model()->findByPk( $problem_id );
				$ans = chr( $user_ans+ord('A') );
				$ref_ans = $problem_model->reference_ans;
		
				if ( $ans == $ref_ans ) {
					$check_ret[] = array( $problem_id => 1 );
				}else {
					$check_ret[] = array( $problem_id => 0 );
				}
			}
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
