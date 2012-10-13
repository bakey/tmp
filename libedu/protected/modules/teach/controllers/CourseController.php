<?php

class CourseController extends Controller
{
	const TBL_ITEM = "tbl_item";
	const TBL_ITEM_LEVEL = "tbl_item_item";
	//public $layout='//layouts/online_column';
	
	private function is_teacher() 
	{
		return Yii::app()->user->urole == Yii::app()->params['user_role_teacher'];
	}
	private function getPostCntByItem( $item_id )
	{
		return CoursePost::model()->count( 'item_id=' . $item_id);
	}
	
	private function get_current_item_info( $user_model , $top_item_model , $course_id )
	{		
		$children_item = $top_item_model->level_child;
		$item_info = array();
	
		foreach( $children_item as $item )
		{
			$url = "";
			$operate = "";
			
			$post_model = CoursePost::model()->findAll('item_id=:iid order by update_time desc',
					array(':iid' => $item->id) );
			
			$new_url = CController::createUrl("/teach/coursepost/create&item_id=" . $item->id . "&course_id=" . $course_id );
			$new_op = "新建课程";				

			$view_url = CController::createUrl("/teach/coursepost/index&item_id=" . $item->id );
			$view_op = "浏览课程";				
			
			$info = array(
					'id'         => $item->id,
					'new_url'    => $new_url,
					'view_url'   => $view_url,
					'item_index' => $item->edi_index,
					'content'    => $item->content,
					'new_post'   => $new_op,
					'view_post'  => $view_op,
					'operate'    => $operate,
					'post_count' => $this->getPostCntByItem( $item->id ),
			);
			if ( count($post_model) <= 0 ) {
				$info['update_time'] = '没数据';
			}
			else {
				$info['update_time'] = $post_model[0]->update_time;
			}
			$item_info[] = $info;
		} 
		return  $item_info ;
	}
	private function renderTeacherCoursePost( $user_model , $course_id , $edition_id )
	{
		$top_item_model = $user_model->trace_item;
		if ( count($top_item_model) != 1  ) {
			throw new CHttpException( 400 , "trace item data corruption");
		}
		//获取当前章节下面的各个子章节的信息.
		$current_item_info = $this->get_current_item_info( $user_model , $top_item_model[0] , $course_id );
		$edition_first_level_items = Item::model()->findAll( 'edition=:edition and level=1', array(
				':edition' => $edition_id, ) );
		
		if ( null == $edition_first_level_items ) {
			throw new CHttpException( 400 , "trace item data corruption");
		}
		$this->render('update_teacher_course' , array(
				'current_item'      => $top_item_model[0],
				'item_info'  		=> $current_item_info ,
				'level_one_items'   => $edition_first_level_items,
				'course_id'         => $course_id,
		));		
	}
	private function renderStudentCoursePost( $user_model , $course_id , $edition_id )
	{
		$user_course_model = UserCourse::model()->find( 'course_id=:cid and role=:teacher_role' , 
											array( ':cid'=>$course_id , ':teacher_role' => Yii::app()->params['user_role_teacher']) );
		if ( null == $user_course_model ) {
			throw new CHttpException( 404 , "这门课没有老师吗？");
		}		
		$teacher_model = LibUser::model()->findByPk( $user_course_model->user_id );
		$top_item_model = $teacher_model->trace_item ;

		$tracing_item_info = $this->get_current_item_info( $teacher_model , $top_item_model[0] , $course_id );
		$edition_first_level_items = Item::model()->findAll( 'edition=:edition and level=1', array(
				':edition' => $edition_id, ) );		
		$this->render('update_student_course' , array(
				'top_item'        => $top_item_model[0],
				'tracing_item'    => $tracing_item_info,
				'level_one_items' => $edition_first_level_items,
		
				//'ajax_load_url' => $url ,
		));		
	}
	/*
	 * 获取课程对应的教材的第一层章节
	*/
	public function actionLoadTopLevelItem( $course_id , $edition_id )
	{
		$edition_first_level_items = Item::model()->findAll( 'edition=:edition and level=1', array(
				':edition' => $edition_id, ) );
		$this->renderPartial( '_total_item_list' , array( 'top_items' => $edition_first_level_items ) );		
	}
	public function actionAdmin()
	{
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );
		$courses = $user_model->user_course;
		$userCourseData = new CArrayDataProvider( $courses , array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('admin' , array(
				//'dataProvider'=>$userCourseData,
					'course_data' => $courses,
				));
	}

	public function actionIndex()
	{
		if ( LibUser::is_school_admin() )
		{
			$schoolid = Yii::app()->params['currentSchoolID'] ;
			$criteria = new CDbCriteria;
			$criteria->compare('school_id',$schoolid);
			
			$courses=Course::model()->findAll($criteria);
			$this->render('admin_course',array(
					'courseModel'=>$courses,
					'schoolid'=>$schoolid,
			));
		}
		else 
		{
			$user_id = Yii::app()->user->id;
			$user_model = LibUser::model()->findByPk( $user_id );
			$courses = $user_model->user_course;
			$userCourseData = new CActiveDataProvider('Course',array(
								'pagination'=>array('pageSize'=>15),));
			$userCourseData->setData( $courses );
			$this->render('index' , array(
					'dataProvider'=>$userCourseData,
					));
		}
	}
	public function loadEditionModel( $id )
	{
		$course_model = Course::model()->findByPk( $id );
		if ( $course_model == null ) {
			throw new CHttpException(404 , "此课程对应的教材id有误");
		}
		else {
			return $course_model->edition;
		}
	}
	public function loadCourseModel( $course_id )
	{
		$course_model = Course::model()->findByPk( $course_id );
		if ( $course_model == null ) {
			throw new CHttpException(404 , "此课程对应的教材id有误");
		}
		return $course_model;
	}
	/*
	 * @获取当前用户的在当前item的post存在与否的判断
	 */
	public function getItemPostStatus($user_id , $item_id)
	{
		$status = array();
		$exist = CoursePost::model()->exists(
				'author=:author and item_id=:item_id',
				array(
						':author'=>$user_id ,
						':item_id'=>$item_id,
				)
		);
		return array(
				'post_exist' => $exist,
		);
	}
	public function actionUpdate( $course_id )
	{
		Yii::app()->user->setState( "course" , $course_id );
		$edition_id = $this->loadCourseModel( $course_id )->edition->id;
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );

		if ( $this->is_teacher() ) {
			$this->renderTeacherCoursePost( $user_model , $course_id , $edition_id );
		}else {
			$this->renderStudentCoursePost( $user_model , $course_id , $edition_id );
		}
	}
	/*
	 * 获取某个item的所有子item，并以表格的方式渲染回去
	 */
	public function actionLoadChildItemAsTable( $item )
	{
			$item_id = $_GET['item'];
			$course_id = Yii::app()->user->course;
			$user_id = Yii::app()->user->id;
			
			$user_model = LibUser::model()->findByPk( $user_id );
			//当前要展开的那个item model
			$query_item = Item::model()->findByPk( $item_id );
			//获取要展开的那个item的所有子item
			//$children_items = $query_item->level_child;
			//当前此用户正在跟踪的第一层item
		//	$tracing_item = LibUser::model()->findByPk( Yii::app()->user->id )->trace_item[0];
			
			$item_info = $this->get_current_item_info($user_model, $query_item, $course_id);
			
			if ( $this->is_teacher() ) {
				$this->renderPartial( '_show_teacher_item' , array(
						'dataProvider' =>  $item_info ,
				) );
			}else {
				$this->renderPartial( '_show_student_item' , array( 'dataProvider' => $item_info ) );
			}
			
			/*//通过item的edi_index来判断谁先谁后
			$before_tracing = false;
			$sub_item_model = null;
			if ( $query_item->edi_index < $tracing_item->edi_index ) {
				$before_tracing = true;				
			}else if ( $query_item->edi_index == $tracing_item->edi_index ) {
				//如果要展开的item正好是当前tracing的item,那么需要判断tracing的第二层item.
				$tracing_model = TeacherItemTrace::model()->findByPk( $user_id );
				if ( $tracing_model->sub_item < 0 ) {
					//如果当前的一层章节已经tracing到末尾了，那么此item下item全部都是浏览课程
					$before_tracing = true ;
				}else {
					$sub_item_model = Item::model()->findByPk( $tracing_model->sub_item );					
				}
			}
			$item_data = array();
			foreach( $children_items as $item )
			{
				$url = "";
				$op = "";
				if ( $before_tracing ) {
					$url = CController::createUrl("/teach/coursepost/index&item_id=") . $item->id;
					$op  = '浏览课程';					
				}
				else {
					if ( null != $sub_item_model && $item->edi_index < $sub_item_model->edi_index ) {
						$url = CController::createUrl("/teach/coursepost/index&item_id=") . $item->id;
						$op  = '浏览课程';						
					}else { 
						$url = CController::createUrl("/teach/coursepost/create&item_id=") . $item->id . "&course_id=" . $course_id ;
						$op = '新建课程';
					}				
				}
				$info = array( 'id'=>$item->id , 'url'=>$url , 'operate'=>$op , 'edi_index'=>$item->edi_index,
						'content'=>$item->content );
				$item_data[] = $info;
			}	*/
	}
	public function actionAjaxLoadItem()
	{
		$parentId = null ;
		$edition_id = null ;
		$course_id = null;
		$levelCondition = "";
		$user_id = Yii::app()->user->id;
		$cur_level = 0;
		
		if ( isset($_GET['edition_id']) ) {
			$edition_id = $_GET['edition_id'];
		}
		if ( isset($_GET['course_id']) ) {
			$course_id = $_GET['course_id'];
		}
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parentId = (int) $_GET['root'];
				$levelCondition = " tbl_item.level > 1 " ;
				$cur_level = 1;
			}else if( isset($_GET['edition_id']) ) {
				//第一层查询
				//$parentId = (int)$_GET['edition_id'];
				$levelCondition = " tbl_item.level <=> 1 ";
			}
			else {
				exit();
			}
		}
		else {
			exit();
		}
		//echo( $levelCondition );
		
		/*
		 * 我们期望或得到类似" id content hasChildren"排列的数据，通过json方式返回给ajax调用，
		* 前端接收到后根据这个信息渲染出树状结构。
		*/
		$sql_cmd = sprintf("SELECT %s.id, %s.content AS text, max(%s.id<=>%s.parent) AS hasChildren FROM %s join %s where %s.edition <=> %s ",
				self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , $edition_id );
		
		
		if ( $parentId != null)
		{
			$sql_cmd .= " and tbl_item.id <=> tbl_item_item.child ";
			$sql_cmd .= " and tbl_item_item.parent <=> " . $parentId ;
		}
		$sql_cmd .= " and " . $levelCondition . " group by tbl_item.id";
		
		// read the data (this could be in a model)
		$children = Yii::app()->db->createCommand( $sql_cmd )->queryAll();
		
		$treedata=array();
		foreach($children as $child){
			$status = $this->getItemPostStatus($user_id , $child['id']);
			$item_model = Item::model()->findByPk( $child['id'] );
			$content = "第" . $item_model->edi_index;
			if ( $cur_level > 0 ){
				$content .= " 节:";
			}else {
				$content .= " 章:";
			}
			$url = "";			
			if ( !$status['post_exist'] ) {
				$url = CController::createUrl('coursepost/create&item_id=' . $child['id'] . '&course_id=' . $course_id );
			}else {
				$url = CController::createUrl('coursepost/index&item_id=' .$child['id'] . '&course_id=' . $course_id );
			}
			$child['text'] = $content . $child['text'];
			
			$options=array('href'=>$url,'id'=>$child['id'],'class'=>'treenode');
			$nodeText = CHtml::openTag('a', $options);
			$nodeText.= $child['text'];
			$nodeText.= CHtml::closeTag('a')."\n";
			$child['text'] = $nodeText;
			$treedata[]=$child;
		}
		
		echo str_replace(
				'"hasChildren":"0"',
				'"hasChildren":false',
				CTreeView::saveDataAsJson($treedata)
		);
		
	}
	
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
				array('allow',
						'actions'=>array('index' , 'update','ajaxLoadItem'),
						'users'=>array('@'),
						),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('admin','loadchilditemastable','loadtoplevelitem'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	
}