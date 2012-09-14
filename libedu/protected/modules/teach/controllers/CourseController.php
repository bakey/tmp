<?php

class CourseController extends Controller
{
	const TBL_ITEM = "tbl_item";
	const TBL_ITEM_LEVEL = "tbl_item_item";
	public function actionAdmin()
	{
		$uid = Yii::app()->user->id;
		$dataProvider=new CActiveDataProvider('Course',array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('admin' , array(
				'dataProvider'=>$dataProvider,
				));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Course',array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('index' , array(
				'dataProvider'=>$dataProvider,
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
	public function actionUpdate( $id )
	{
		//取得此课程对应的教材，用以确定章节
		$edition_model = $this->loadEditionModel( $id );
		$edition_id = $edition_model->id;
		$user_id = Yii::app()->user->id;
		$item_post = array();
		foreach( $edition_model->getItems() as $item )
		{
			$exist = CoursePost::model()->exists(
					'author=:author and item_id=:item_id',
						array(
							':author'=>$user_id ,
							':item_id'=>$item->id,
						)
				);
			$item_post[] = array( 'item' => $item , 'post_exist'=>$exist );
		}
		$this->render('update' , array(
				'item_post'=>$item_post,
				'edition_id'=>$edition_id,
		));
	
			// accept only AJAX request (comment this when debugging)
			/*if (!Yii::app()->request->isAjaxRequest) {
				exit();
			}*/
			
	}
	public function actionAjaxLoadItem()
	{
		$parentId = null ;
		$editionId = null ;
		$levelCondition = "";
		$user_id = Yii::app()->user->id;
		
		if ( isset($_GET['edition_id']) ) {
			$editionId = $_GET['edition_id'];
		}
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parentId = (int) $_GET['root'];
				$levelCondition = " tbl_item.level > 1 " ;
			}else if( isset($_GET['edition_id']) ) {
				//第一层查询
				//$parentId = (int)$_GET['edition_id'];
				$levelCondition = " tbl_item.level <=> 1 ";
			}
			else {
				exit();
			}
		}
		
		/*
		 * 我们期望或得到类似" id content hasChildren"排列的数据，通过json方式返回给ajax调用，
		* 前端接收到后根据这个信息渲染出树状结构。
		*/
		$sql_cmd = sprintf("SELECT %s.id, %s.content AS text, max(%s.id<=>%s.parent) AS hasChildren FROM %s join %s where %s.edition <=> %s ",
				self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , $editionId );
		
		
		if ( $parentId != null)
		{
			$sql_cmd .= " and tbl_item.id <=> tbl_item_item.child ";
			$sql_cmd .= " and tbl_item_item.parent <=> " . $parentId ;
		}
		$sql_cmd .= " and " . $levelCondition . " group by tbl_item.id";
		
		
		// read the data (this could be in a model)
		$children = Yii::app()->db->createCommand( $sql_cmd )->queryAll();
		
		//$url = CController::createUrl('coursepost/index');
		
		$treedata=array();
		foreach($children as $child){
			$status = $this->getItemPostStatus($user_id , $child['id']);
			$item_model = Item::model()->findByPk( $child['id'] );
			$content = "第" . $item_model->edi_index . " 章:";
			$url = "";
			//var_dump( $status['post_exist'] );			
			if ( !$status['post_exist'] ) {
				$url = CController::createUrl('coursepost/create&item_id=' . $child['id'] );
			}else {
				$url = CController::createUrl('coursepost/index');
			}
			$child['text'] = $content . $child['text'];
			//var_dump( $child['text']);
			
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
				//CTreeView::saveDataAsJson($children)
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