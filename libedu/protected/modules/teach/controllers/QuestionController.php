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
				'actions'=>array('create','update','getchapterfromcourse','ajaxfilltree','answer','getallsubelement','generatequestionfeed','myquestion','getquestionbyitem','zwtoanswer','questionnotanswered','allmyansweredquestion','questionfromme','answerzwtoanswer'),
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
			$this->renderPartial('_view',array(
				'data'=>$model,
			));
			}
		}

		/*$mycourse = LibUser::model()->findByPk(Yii::app()->user->id);
		$mycourse = $mycourse->user_course;
		
		$res = array();
		foreach ($mycourse as $singlecourse) {
			$res[$singlecourse->id ] = $singlecourse->name;
		}*/
		/*$this->render('create',array(
			'model'=>$model,
			'mycourse'=>$res,
		));*/
	}

	public function actionGenerateQuestionFeed(){
		$cquestion = Question::model()->findByPk($_GET['rid']);
		$cusr = LibUser::model()->findByPk($_GET['uid']);
		$this->renderPartial('question_timeline',array('cquestion'=>$cquestion,'cusr'=>$cusr));
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

		if(isset($_REQUEST['subans'])){
			$tempans = Answer::model()->findByPk($qid);
			$cq = Question::model()->findByPk($tempans->question_id);
		}
		if(!$cq){
			throw new CHttpException(403,'问题不存在');
		}else{
			if(isset($_POST['Answer']))
			{
				$model->attributes=$_POST['Answer'];
				$model->question_id = $qid;
				$model->owner = Yii::app()->user->id;
				$model->create_time = date("Y-m-d H:i:s");
				if(isset($_REQUEST['subans'])){
					$model->level = $qid;
					$upans = Answer::model()->findByPk($qid);
					$model->question_id = $upans->question_id;
				}
				if($model->save()){
					QuestionKp::model()->deleteAllByAttributes(array('question'=>$qid));
					if(isset($_POST['kprelation'])){
						if(count($_POST['kprelation'])!=0){
							foreach ($_POST['kprelation'] as $singlekprealtion) {
								$ckpr = new QuestionKp;
								$ckpr->question = $qid;
								$ckpr->knowledge_point = $singlekprealtion;
								$ckpr->save();
							}
						}
					}
					echo 'success';
				}
			}
		}
	}

	public function actionGetAllSubElement($qid,$type){
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
			$res = Answer::model()->findAllByAttributes(array('question_id'=>$qid,'type'=>$type,'level'=>0),array('order'=>'type DESC'));
			if(!$res){
				$this->renderPartial('_answer',array('model'=>$model,
				'mycourse'=>$res,
				'qid'=>$qid,
				'cq'=>$cq,
				'kp'=>$reskp,
				'anstyp'=>$type,
				'skp'=>$selkp,),false,true);
				echo '<h2>所有'; echo $type==1? '追问' : '回答'; echo'</h2><p>还没有任何'; echo $type==1? '追问' : '回答'; echo '</p>';
				echo '<script type="text/javascript">
	function submitAnswer(qid){
		var data1=$("#question-form"+qid).serialize();
		$.ajax({
	    type: "POST",
	    url: "'.Yii::app()->createUrl("/teach/question/answer",array("qid"=>$qid)).'",
	    data:data1,
	    success:function(data){
	    			if(data == "success"){
	    				var caloader = \'<div class="libajaxloader libajaxloaderwithbg"></div>\';
	    				$("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text("';echo $type==1? '追问' : '回答'; echo '("+(parseInt($("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text().match(/\d/g))+1)+")").hide().fadeIn();
	    				$("#answer'.$qid.'").append(caloader);
	    				$("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").click();
	    			}
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
	 
	}
</script>';
			}else{
				$this->renderPartial('_answer',array('model'=>$model,
				'mycourse'=>$res,
				'qid'=>$qid,
				'cq'=>$cq,
				'kp'=>$reskp,
				'anstyp'=>$type,
				'skp'=>$selkp,),false,true);
				for($i=0;$i<count($res);$i++){

					$this->renderPartial('_subAnswer',array('data'=>$res[$i]),false,true);
				}
				echo '<script type="text/javascript">
	function submitAnswer(qid){
		var data1=$("#question-form"+qid).serialize();
		$.ajax({
	    type: "POST",
	    url: "'.Yii::app()->createUrl("/teach/question/answer",array("qid"=>$qid)).'",
	    data:data1,
	    success:function(data){
	    			if(data == "success"){
	    				var caloader = \'<div class="libajaxloader libajaxloaderwithbg"></div>\';
	    				$("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text("';echo $type==1? '追问' : '回答'; echo '("+(parseInt($("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text().match(/\d/g))+1)+")").hide().fadeIn();
	    				$("#answer'.$qid.'").append(caloader);
	    				$("#';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").click();
	    			}
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
	 
	}
</script>';
			}
		}
	}

	public function actionAnswerZwToAnswer($qid,$type){
		$model = new Answer;
		$this->renderPartial('_answer',array('model'=>$model,
			'qid'=>$qid,
			'anstyp'=>$type,'level'=>2),false,true);
		echo '<script type="text/javascript">
	function submitSubbAnswer(qid){
		var data1=$("#subquestion-form"+qid).serialize();
		$.ajax({
	    type: "POST",
	    url: "'.Yii::app()->createUrl("/teach/question/answer",array("qid"=>$qid,"subans"=>1)).'",
	    data:data1,
	    success:function(data){
	    			if(data == "success"){
	    				var caloader = \'<div class="libajaxloader libajaxloaderwithbg"></div>\';
	    				$("#bottomansdiv'.$qid.'").append(caloader);
	    				$("#subzwtrigger'.$qid.'").click();
	    				$("#overlays .modal").fadeOut(100);
						$("#overlays").removeClass();
						$(document).unbind("keyup");
	    			}
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
	 
	}
</script>';
	}

	public function actionZwToAnswer($qid,$type){
		$model=new Answer;
		
		$cq = Answer::model()->findByPk($qid);

		if(!$cq){
			throw new CHttpException(403,'回答不存在');
		}else{
			//get kp by question kp relation
			$res = Answer::model()->findAllByAttributes(array('level'=>$qid,'type'=>$type),array('order'=>'create_time DESC',));
			if(!$res){
				$this->renderPartial('_answer',array('model'=>$model,
				'qid'=>$qid,
				'cq'=>$cq,
				'anstyp'=>$type,'level'=>1),false,true);
				echo '<h2>所有'; echo $type==1? '追问' : '回答'; echo'</h2><p>还没有任何'; echo $type==1? '追问' : '回答'; echo '</p>';
				echo '<script type="text/javascript">
	function submitSubAnswer(qid){
		var data1=$("#subquestion-form"+qid).serialize();
		$.ajax({
	    type: "POST",
	    url: "'.Yii::app()->createUrl("/teach/question/answer",array("qid"=>$qid,"subans"=>1)).'",
	    data:data1,
	    success:function(data){
	    			if(data == "success"){
	    				var caloader = \'<div class="libajaxloader libajaxloaderwithbg"></div>\';
	    				$("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text("';echo $type==1? '追问' : '回答'; echo '("+(parseInt($("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text().match(/\d/g))+1)+")").hide().fadeIn();
	    				$("#subanswer'.$qid.'").append(caloader);
	    				$("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").click();
	    			}
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
	 
	}
</script>';
			}else{
				$this->renderPartial('_answer',array('model'=>$model,
				'qid'=>$qid,
				'cq'=>$cq,
				'anstyp'=>$type,
				'level'=>1,
				),false,true);
				for($i=0;$i<count($res);$i++){
					$this->renderPartial('_subAnswer',array('data'=>$res[$i]),false,true);
				}
				echo '<script type="text/javascript">
	function submitSubAnswer(qid){
		var data1=$("#subquestion-form"+qid).serialize();
		$.ajax({
	    type: "POST",
	    url: "'.Yii::app()->createUrl("/teach/question/answer",array("qid"=>$qid,"subans"=>1)).'",
	    data:data1,
	    success:function(data){
	    			if(data == "success"){
	    				var caloader = \'<div class="libajaxloader libajaxloaderwithbg"></div>\';
	    				$("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text("';echo $type==1? '追问' : '回答'; echo '("+(parseInt($("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").text().match(/\d/g))+1)+")").hide().fadeIn();
	    				$("#subanswer'.$qid.'").append(caloader);
	    				$("#sub';echo $type==1? 'zw' : 'answer'; echo 'trigger'.$qid.'").click();
	    			}
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
	 
	}
</script>';
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
					$nodeText = '<a id="child'.$child['id'].'" href="javascript:void(0);" onclick="doselectchapter(event,'.$child['id'].')">'.$child['text'].'</a>';
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
		if(isset(Yii::app()->user->course)){
			$edition = Course::model()->findByPk(Yii::app()->user->course);
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


	public function actionAllMyAnsweredQuestion()
	{
		$ccourse = null;
		$eid = null;
		if(isset(Yii::app()->user->course)){
			$ccourse = Yii::app()->user->course;
			$edition = Course::model()->findByPk($ccourse);
			$edition = $edition->edition;
		}
		if(Yii::app()->user->urole == 1)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
       				 'condition'=>'owner='.Yii::app()->user->id,
        			'order'=>'create_time DESC',
    		),));
		}
		else if(Yii::app()->user->urole == 2)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
			'select'=>'t.id,t.owner,t.item,t.details,t.create_time,t.view_count,tbl_item.edition,SUM(CASE WHEN (tbl_answer.type = 2 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofanswers, SUM(CASE WHEN (tbl_answer.type = 1 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofzw, SUM(CASE WHEN tbl_answer.owner = '.Yii::app()->user->id.' THEN 1 ELSE 0 END) AS numberofmyanswer ',
	        'join'=>'LEFT JOIN tbl_item ON t.item = tbl_item.id LEFT JOIN tbl_answer ON tbl_answer.question_id = t.id',
	        'condition'=>'tbl_item.edition='.$edition->id,
	        'group'=>'t.id',
	        'together'=>true,
	        'having'=>' numberofmyanswer > 0',
	        'order'=>'t.create_time DESC',
	    	),
			'pagination'=>array(
                'pageSize'=>5,
            ),
	    	));
		}
		
		$this->render('myanswered',array(
			'dataProvider'=>$dataProvider,
			'ccourse' =>$ccourse,
			'eid'=>$edition->id,
		));
		
	}	


	public function actionQuestionFromMe()
	{
		$ccourse = null;
		$eid = null;
		if(isset(Yii::app()->user->course)){
			$ccourse = Yii::app()->user->course;
			$edition = Course::model()->findByPk($ccourse);
			$edition = $edition->edition;
		}
		if(Yii::app()->user->urole == 1)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
       				 'condition'=>'owner='.Yii::app()->user->id,
        			'order'=>'create_time DESC',
    		),));
		}
		else if(Yii::app()->user->urole == 2)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
			'select'=>'t.id,t.owner,t.item,t.details,t.create_time,t.view_count,tbl_item.edition,SUM(CASE WHEN (tbl_answer.type = 2 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofanswers, SUM(CASE WHEN (tbl_answer.type = 1 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofzw',
	        'join'=>'LEFT JOIN tbl_item ON t.item = tbl_item.id LEFT JOIN tbl_answer ON tbl_answer.question_id = t.id',
	        'condition'=>'tbl_item.edition='.$edition->id.' AND t.owner = '.Yii::app()->user->id,
	        'group'=>'t.id',
	        'together'=>true,
	        'order'=>'t.create_time DESC',
	    	),
			'pagination'=>array(
                'pageSize'=>5,
            ),
	    	));
		}
		
		$this->render('questionfromme',array(
			'dataProvider'=>$dataProvider,
			'ccourse' =>$ccourse,
			'eid'=>$edition->id,
		));
		
	}

	public function actionQuestionNotAnswered()
	{
		$ccourse = null;
		$eid = null;
		if(isset(Yii::app()->user->course)){
			$ccourse = Yii::app()->user->course;
			$edition = Course::model()->findByPk($ccourse);
			$edition = $edition->edition;
		}
		if(Yii::app()->user->urole == 1)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
       				 'condition'=>'owner='.Yii::app()->user->id,
        			'order'=>'create_time DESC',
    		),));
		}
		else if(Yii::app()->user->urole == 2)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
			'select'=>'t.id,t.owner,t.item,t.details,t.create_time,t.view_count,tbl_item.edition,SUM(CASE WHEN (tbl_answer.type = 2 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofanswers, SUM(CASE WHEN (tbl_answer.type = 1 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofzw',
	        'join'=>'LEFT JOIN tbl_item ON t.item = tbl_item.id LEFT JOIN tbl_answer ON tbl_answer.question_id = t.id',
	        'condition'=>'tbl_item.edition='.$edition->id,
	        'group'=>'t.id',
	        'together'=>true,
	        'having'=>' numberofanswers = 0',
	        'order'=>'t.create_time DESC',
	    	),
			'pagination'=>array(
                'pageSize'=>5,
            ),
	    	));
		}
		
		$this->render('notanswered',array(
			'dataProvider'=>$dataProvider,
			'ccourse' =>$ccourse,
			'eid'=>$edition->id,
		));
		
	}	

	public function actionMyQuestion()
	{
		$ccourse = null;
		$eid = null;
		if(isset(Yii::app()->user->course)){
			$ccourse = Yii::app()->user->course;
			$edition = Course::model()->findByPk($ccourse);
			$edition = $edition->edition;
		}
		if(Yii::app()->user->urole == 1)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
       				 'condition'=>'owner='.Yii::app()->user->id,
        			'order'=>'create_time DESC',
    		),));
		}
		else if(Yii::app()->user->urole == 2)
		{
			$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
			'select'=>'t.id,t.owner,t.item,t.details,t.create_time,t.view_count,tbl_item.edition,SUM(CASE WHEN (tbl_answer.type = 2 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofanswers, SUM(CASE WHEN (tbl_answer.type = 1 AND tbl_answer.level = 0) THEN 1 ELSE 0 END) AS numberofzw',
	        'join'=>'LEFT JOIN tbl_item ON t.item = tbl_item.id LEFT JOIN tbl_answer ON tbl_answer.question_id = t.id',
	        'condition'=>'tbl_item.edition='.$edition->id,
	        'group'=>'t.id',
	        'together'=>true,
	        'order'=>'t.create_time DESC',
	    	),
			'pagination'=>array(
                'pageSize'=>5,
            ),
	    	));
		}
		if(isset($_REQUEST['refreshafteraddquestion'])){
			$this->renderPartial('myquestionrefresh',array(
				'dataProvider'=>$dataProvider,
				'ccourse' =>$ccourse,
				'eid'=>$edition->id,
			),false,true);
		}else{
			$this->render('myquestion',array(
				'dataProvider'=>$dataProvider,
				'ccourse' =>$ccourse,
				'eid'=>$edition->id,
			));
		}
	}


	public function actionGetQuestionByItem()
	{
		$chid = 0;
		if(isset($_POST['chid'])){
			$chid = $_POST['chid'];
		}else if(isset($_REQUEST['chid'])){
			$chid = $_REQUEST['chid'];
		}
		$dataProvider=new CActiveDataProvider('Question',array('criteria'=>array(
		'select'=>'t.id,t.owner,t.item,t.details,t.create_time,t.view_count,tbl_item.edition,SUM(CASE WHEN tbl_answer.type = 2 THEN 1 ELSE 0 END) AS numberofanswers, SUM(CASE WHEN tbl_answer.type = 1 THEN 1 ELSE 0 END) AS numberofzw',
	        'join'=>'LEFT JOIN tbl_item ON t.item = tbl_item.id LEFT JOIN tbl_answer ON tbl_answer.question_id = t.id',
        'condition'=>'item='.$chid,
        'order'=>'create_time DESC',
        'group'=>'t.id',
    ),'pagination'=>array(
                'pageSize'=>5,
            ),)
		);
		$this->renderPartial('index',array(
			'dataProvider'=>$dataProvider,
		),false,true);
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
