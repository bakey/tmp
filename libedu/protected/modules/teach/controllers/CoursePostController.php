<?php

class CoursePostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
				'actions'=>array('admin','delete','create','update','upload'),
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
	/*
	 * 处理用户上传二进制文件
	 */
	public function actionUpload()
	{
		$uid = Yii::app()->user->id;
		$file_name = md5( $_FILES['file']['tmp_name'] ) . ".";
		$suffix = explode( '/' , $_FILES['file']['type'] );
		$file_name .= $suffix[1];
		$target_folder = "./" . Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/origin/';
		$thumb_folder = './' . Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/thumb/';
		if ( !is_dir( $target_folder ) ) {
			mkdir( $target_folder );
		} 
		if ( !is_dir( $thumb_folder ) ) {
			mkdir( $thumb_folder );
		}
		copy( $_FILES['file']['tmp_name'] , $target_folder.$file_name );
		
		Yii::import("ext.EPhpThumb.EPhpThumb");
		$thumb=new EPhpThumb();
		$thumb->init();
		$thumb->create( $target_folder . $file_name )
		->resize(1024,800)
		->save( $thumb_folder . $file_name );
		
		$image_thumb_url = Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				Yii::app()->params['uploadFolder'].'/temp_upload/'. $uid . '/thumb/' . $file_name;
		$image_origin_url = Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				Yii::app()->params['uploadFolder'].'/temp_upload/'. $uid . '/origin/' . $file_name;
		
		$image_code =  CHtml::image( $image_thumb_url );
		echo CHtml::link( $image_code , $image_origin_url );
				
	
		exit();	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$course_post_model =new CoursePost;
		$course_post_model->unsetAttributes();
		$item_id = $_GET['item_id'];
		$course_id = $_GET['course_id'];
		if ( $item_id == null ) {
			throw new CHttpException(400 , "参数错误，没有item_id");
		}
		if ( $course_id == null ) {
			throw new CHttpException( 400 , "参数错误，没有course_id");
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if( isset($_POST['CoursePost']) )
		{
			if ( isset( $_POST['draft']) )
			{
				//存草稿	
				$course_post_model->attributes=$_POST['CoursePost'];
				$course_post_model->create_time = $course_post_model->update_time = date("Y-m-d H:i:s", time() );
				$course_post_model->author = Yii::app()->user->id;
				$course_post_model->item_id = $_GET['item_id'];
				$course_post_model->status = CoursePost::STATUS_DRAFT;
				if($course_post_model->save())
				{
					$this->redirect(array('view','id'=>$course_post_model->id));
				}			
			}
			else if ( isset($_POST['cancel']) )
			{
				//取消，重定向				
				$this->redirect(array('course/update','id'=>$course_id));
			}
			else
			{
				$course_post_model->attributes=$_POST['CoursePost'];
				$course_post_model->create_time = $course_post_model->update_time = date("Y-m-d H:i:s", time() );
				$course_post_model->author = Yii::app()->user->id;
				$course_post_model->item_id = $_GET['item_id'];
				$course_post_model->status = CoursePost::STATUS_PUBLISH;
				if($course_post_model->save())
				{
					$this->redirect(array('view','id'=>$course_post_model->id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$course_post_model,
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

		if(isset($_POST['CoursePost']))
		{
			$model->attributes=$_POST['CoursePost'];
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
		$cur_user = Yii::app()->user->id;
		$item_id = -1;
		if ( isset($_GET['item_id']) ){
			$item_id = $_GET['item_id'];
		}else {
			throw new CHttpException( 500 , "缺少item_id参数");
		}
		$dataProvider=new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'condition'=>('author='.$cur_user.' and item_id='.$item_id ),						
				),
				'pagination'=>array(
						'pageSize'=>15,
				)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CoursePost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CoursePost']))
			$model->attributes=$_GET['CoursePost'];

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
		$model=CoursePost::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
