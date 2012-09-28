<?php

class ProblemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/online_column';
	private $SINGLE_CHOICE = 0;
	private $MULTI_CHOICE = 1;
	private $BLANK = 2;
	private $QA = 3;

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
				'actions'=>array('index','view','test'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				//'actions'=>array('index','create','upload','update','admin','delete'),
				'actions'=>array('index','create','upload','autosave','update','admin','delete'),
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
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='problem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
	private function savePrblemKnowledgePoint( /*array*/ $knowledgePoints , $pid )
	{
		$succ_cnt = 0;
		foreach( $knowledgePoints as $kp )
		{
			$problem_kp_model = new ProblemKp ;
			$problem_kp_model->problem_id = $pid ;
			$problem_kp_model->knowledge_point = $kp;
			if ( $problem_kp_model->save() ) {
				++ $succ_cnt;
			}				
		}
		return $succ_cnt;		
	}
	public function actionTest()
	{
		//print_r( CHtml::listData(KnowledgePoint::model()->findAll(), 'id', 'name') );
		$school_id = Yii::app()->params['currentSchoolID'];
		echo($school_id);
	}
	public function actionAutoSave()
	{
		var_dump( $_POST );
		exit();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$problem_model = new Problem;
		$problem_model->school = Yii::app()->params['currentSchoolID'];
		$this->performAjaxValidation( $problem_model );
		$problem_model->create_time = $problem_model->update_time = date('Y-m-d H:i:s',time());
		$subjects = Subject::model()->findAll();
		$subjectList = CHtml::listData($subjects, 'id', 'name');
	

		if(isset($_POST['Problem']))
		{
			$problem_model->subject    = $_POST['Problem']['subject'];
			$problem_model->type       = $_POST['topic'];
			$problem_model->source     = $_POST['Problem']['source'];
			$problem_model->difficulty = $_POST['Problem']['difficulty'];
			$problem_model->use_count  = 0;
			if($problem_model->type == $this->SINGLE_CHOICE )
			{
				$problem_model->reference_ans = $_POST['same'];
			}
			if( $problem_model->type == $this->MULTI_CHOICE )
			{
				$types = $_POST['same'];
				for( $i=0 ; $i<count($types) ; $i++ )
				{
					$problem_model->reference_ans = $problem_model->reference_ans.$types[$i];
				}
			}
			$problem_model->content=$_POST['Problem']['content'];
			$num=$_POST['sel'];
			switch( $num )
			{
				case 1:
				{
					$problem_model->select_ans=$_POST['A']."\r\n".$_POST['B']."\r\n".$_POST['C']."\r\n".$_POST['D'] ;
					break;
				}
				case 2:
				{
					$problem_model->select_ans=$_POST['A']."\r\n".$_POST['B']."\r\n".$_POST['C']."\r\n".$_POST['D']."\r\n".$_POST['E'];
					break;
				}
				case 3:
				{
					$problem_model->select_ans=$_POST['A']."\r\n".$_POST['B']."\r\n".$_POST['C']."\r\n".$_POST['D']."\r\n".$_POST['E']."\r\n".$_POST['F'] ;
					break;
				}
				default:
					break;
			}		               
			$problem_model->ans_explain=$_POST['Problem']['ans_explain'];
			//Yii::log("ready save problem" , 'debug');
			if( !$problem_model->save()){
				throw new CHttpException( 500 , "保存问题到数据库失败");
				//$this->redirect(array('index','id'=>$problem_model->id));
			}
			$pid = $problem_model->id;
			if ( isset($_POST['Problem']['problem_cb']) ) {
				$this->savePrblemKnowledgePoint( $_POST['Problem']['problem_cb'] , $pid );
			}
			$this->redirect( array('index','id'=>$problem_model->id) );
		}

		$this->render('create',array(
			'model'=>$problem_model,
		));

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

		if(isset($_POST['Problem']))
		{
			$model->attributes=$_POST['Problem'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	private function getThumbPath( $uid ) {
		if ( null == $uid ) {
			return null;
		}
		return Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/thumb/';
	}
	private function getOriginPath( $uid ) {
		if ( null == $uid ) {
			return null;
		}
		return Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/origin/';
	}
	
	private function getThumbImageUrl( $file_name , $uid ) {
		if ( null == $file_name || null == $uid ) {
			return null;
		}
		return Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				$this->getThumbPath($uid) . $file_name;
	}
	private function getOriginImageUrl( $file_name , $uid ) {
		if ( null == $file_name || null == $uid ) {
			return null;
		}
		return Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				$this->getOriginPath($uid) . $file_name;
	}
	public function actionUpload()
	{
		$uid = Yii::app()->user->id;
		//用用户id+系统的临时文件名做hash来生成正式的文件名
		$file_name = md5( $uid . $_FILES['file']['tmp_name'] ) . ".";
		
		$suffix = explode( '/' , $_FILES['file']['type'] );
		$file_name .= $suffix[1];
		$target_folder = $this->getOriginPath($uid);
		$thumb_folder =  $this->getThumbPath($uid);
		if ( !@is_dir( $target_folder ) ) {
			@mkdir( $target_folder );
		}
		if ( !@is_dir( $thumb_folder ) ) {
			@mkdir( $thumb_folder );
		}
		copy( $_FILES['file']['tmp_name'] , $target_folder.$file_name );
		
		Yii::import("ext.EPhpThumb.EPhpThumb");
		$thumb=new EPhpThumb();
		$thumb->init();
		$thumb->create( $target_folder . $file_name )
		->resize(800,640)
		->save( $thumb_folder . $file_name );
		
		$image_thumb_url = $this->getThumbImageUrl($file_name, $uid);
		$image_origin_url = $this->getOriginImageUrl($file_name, $uid);
		
		$image_node =  CHtml::image( $image_thumb_url );
		echo CHtml::link( $image_node , $image_origin_url );
		
		
		exit();
		
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
			if(!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$school_id = Yii::app()->params['currentSchoolID'];
		$subjects = Subject::model()->findAll();
		$subjectList = CHtml::listData($subjects, 'id', 'name');
		
		$problem_model = new Problem();
		$dataProvider=new CActiveDataProvider( 'Problem' ,
				array(
					'criteria'=>array(
							'condition'=>('school='.$school_id ),
					),
					'pagination'=>array(
							'pageSize'=>15,
					),
				)
		);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'problem'=>$problem_model,
			'subjectList' => $subjectList,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Problem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Problem']))
			$model->attributes=$_GET['Problem'];

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
		$model=Problem::model()->findByPk((int)$id);
		if($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}


}

