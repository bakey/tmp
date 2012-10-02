<?php

class CourseController extends Controller
{
	const TBL_ITEM = "tbl_item";
	const TBL_ITEM_LEVEL = "tbl_item_item";
	//public $layout='//layouts/online_column';
	public function actionAdmin()
	{
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );
		$courses = $user_model->user_course;
		$userCourseData = new CArrayDataProvider( $courses , array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('admin' , array(
				'dataProvider'=>$userCourseData,
				));
	}

	public function actionIndex()
	{
		$user_id = Yii::app()->user->id;
		$user_model = LibUser::model()->findByPk( $user_id );
		$courses = $user_model->user_course;
		$userCourseData = new CActiveDataProvider('Course',array(
				'pagination'=>array('pageSize'=>15),
				));
		$userCourseData->setData( $courses );
		$this->render('index' , array(
				'dataProvider'=>$userCourseData,
				));
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
		//取得此课程对应的教材，用以确定章节
		$course_model = $this->loadCourseModel( $course_id );
		$edition_model = $course_model->edition;
		$edition_id = $edition_model->id;
		$user_model = LibUser::model()->findByPk( Yii::app()->user->id );
		Yii::app()->user->setState( "course" , $course_id );

		$top_item_model = $user_model->trace_item;
		
		$edition_first_level_items = Item::model()->findAll( 'edition=:edition and level=1', array(
						':edition' => $edition_id, ) );
		
	
		if ( null == $edition_first_level_items || count($top_item_model) != 1 ) {
			throw new CHttpException( 400 , "trace item data corruption");
		}
		/*$url = 'course/ajaxLoadItem&edition_id=' . $edition_id . '&course_id=' . $id ;*/
		$this->render('update' , array(
				'top_item'        => $top_item_model[0],
				'level_one_items' => $edition_first_level_items,
				//'ajax_load_url' => $url ,
		));
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
						'actions'=>array('admin'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	
}