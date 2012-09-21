<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	const ITEM_LEVEL_TOP = 1;
	const TBL_ITEM = "tbl_item";
	const TBL_ITEM_LEVEL = "tbl_item_item";

	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','getchapterfromcourse','ajaxfilltree','answer','getallsubelement'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Question;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//get current editon based on 

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$mycourse = LibUser::model()->findByPk(Yii::app()->user->id);
		$mycourse = $mycourse->user_course;
		
		$res = array();
		foreach ($mycourse as $singlecourse) {
			$res[$singlecourse->id ] = $singlecourse->name;
		}
		$this->render('create',array(
			'model'=>$model,
			'mycourse'=>$res,
		));
	}

	public function actionAnswer($qid)
	{
		$model=new Answer;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//get current editon based on 

		$mycourse = LibUser::model()->findByPk(Yii::app()->user->id);
		$mycourse = $mycourse->user_course;
		foreach ($mycourse as $singlecourse) {
			$res[$singlecourse->id ] = $singlecourse->name;
		}
		
		$cq = Question::model()->findByPk($qid);

		if(!$cq){
			throw new CHttpException(403,'问题不存在');
		}else{
			if(isset($_POST['Answer']))
			{
				$model->attributes=$_POST['Answer'];
				$model->question_id = $qid;
				$model->owner = Yii::app()->user->id;
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					QuestionKp::model()->deleteAllByAttributes(array('question'=>$qid));
					foreach ($_POST['kprelation'] as $singlekprealtion) {
						$ckpr = new QuestionKp;
						$ckpr->question = $qid;
						$ckpr->knowledge_point = $singlekprealtion;
						$ckpr->save();
					}
					$this->redirect(array('view','id'=>$qid));
					exit();
				}
			}
			//get kp by question kp relation
			$ckp = ItemKp::model()->findAllByAttributes(array('item'=>$cq->item));
			$reskp = array();
			$selkp = array();
			foreach ($ckp as $singleckp) {
				$orikp = KnowledgePoint::model()->findByPk($singleckp->knowledge_point);
				$reskp[$orikp->id] = $orikp->name;
				if(QuestionKp::model()->findByAttributes(array('question'=>$qid,'knowledge_point'=>$orikp->id))){
					array_push($selkp, $orikp->id);
				}
			}
			$this->render('answer',array(
				'model'=>$model,
				'mycourse'=>$res,
				'qid'=>$qid,
				'cq'=>$cq,
				'kp'=>$reskp,
				'skp'=>$selkp,
			));
		}
	}

	public function actionGetAllSubElement($qid){
		$res = Answer::model()->findAllByAttributes(array('question_id'=>$qid),array('order'=>'type DESC'));
		if(!$res){
			echo '没有回答及追问';
		}else{
			for($i=0;$i<count($res);$i++){
				$this->renderPartial('_subAnswer',array('data'=>$res[$i]),false,true);
			}
		}
	}

	public function actionAjaxFillTree()
	{
		// accept only AJAX request (comment this when debugging)
		/*if (!Yii::app()->request->isAjaxRequest) {
			exit();
		}*/
		// parse the user input
		$parentId = null ;
		$editionId = null ;
		$levelCondition = "";
		
		if ( isset($_GET['edition_id']) ) {
			$editionId = $_GET['edition_id'];
		}
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parentId = (int) $_GET['root'];
				$levelCondition = " level > 1 " ;
			}else if( isset($_GET['edition_id']) ) {
				//第一层查询
				//$parentId = (int)$_GET['edition_id'];
				$levelCondition = " level <=> 1 "; 
			}
			else {
				exit();
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
					 array(':edition'=>$editionId)
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
			$options=array('href'=>'#','id'=>$child['id'],'class'=>'treenode');
			$nodeText = CHtml::openTag('a', $options);
			if(isset($_GET['root'])){
				$res = ItemItem::model()->findByAttributes(array('parent'=>$child['id']));
				if(!$res){
					$nodeText = '<a id="child'.$child['id'].'" href="#" onclick="doselectchapter('.$child['id'].')">'.$child['text'].'</a>';
				}else{
					$nodeText = $child['text'];	
				}
			}
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

	public function actionGetChapterFromCourse(){
		if(isset($_POST['cid'])){
			$edition = Course::model()->findByPk($_POST['cid']);
			$edition = $edition->edition;
			$this->renderPartial('_ajaxGetChapter',array('eid'=>$edition),false,true);
		}else{
			echo 'Bad Request';
		}
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

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
