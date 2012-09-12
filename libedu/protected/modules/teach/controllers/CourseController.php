<?php

class CourseController extends Controller
{
	public function actionAdmin()
	{
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
	public function actionUpdate( $id )
	{
		/*$edition_model = $this->loadEditionModel( $id );
		$this->render('update' , array(
				'edition'=>$edition_model,
			));*/
	
			// accept only AJAX request (comment this when debugging)
			if (!Yii::app()->request->isAjaxRequest) {
				exit();
			}
			// parse the user input
			/*$parentId = null ;
			$editionId = null ;
			$levelCondition = "";
		
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
			}*/
		
			/*
			 * 我们期望或得到类似" id content hasChildren"排列的数据，通过json方式返回给ajax调用，
			* 前端接收到后根据这个信息渲染出树状结构。
			*/
			$sql_cmd = sprintf("SELECT %s.id, %s.content AS text, max(%s.id<=>%s.parent) AS hasChildren FROM %s join %s where %s.edition <=> %s ",
					self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , $editionId );
		
		
			//$sql_cmd = "SELECT tbl_item.id, tbl_item.content AS text, max(tbl_item.id<=>tbl_item_item.parent) AS hasChildren "
			//	."FROM tbl_item join tbl_item_item where tbl_item.edition <=> " . $editionId ;
		
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
				$options=array('href'=>'#','id'=>$child['id'],'class'=>'treenode');
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
						'actions'=>array('index' , 'update'),
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