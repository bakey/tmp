<?php

class ProfileController extends Controller
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
				'actions'=>array('create','update','uploadavatar','cropavatar','generateavatarfeed'),
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
		if(Yii::app()->user->urole == 1){
			$usc = UserSchool::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'school_id'=>Yii::app()->params['currentSchoolID']));
			$ucls = LibUserClass::model()->findByAttributes(array('student_id'=>Yii::app()->user->id));
			$ucls = LibClass::model()->findByPk($ucls->class_id);
			$this->render('view',array(
				'model'=>$this->loadModel($id),
				'usc'=>$usc,
				'ucls'=>$ucls,
			));
		}else if(Yii::app()->user->urole == 2){
			$usc = UserCourse::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id,'role'=>'2'));
			for($i=0;$i<count($usc);$i++){
				$usc[$i] = Course::model()->findByPk($usc[$i]->course_id);
			}
			$ucls = LibUserClass::model()->findAllByAttributes(array('teacher_id'=>Yii::app()->user->id),array('group'=>'class_id','select'=>'class_id,teacher_id'));
			for($i=0;$i<count($ucls);$i++){
				$ucls[$i] = LibClass::model()->findByPk($ucls[$i]->class_id);
			}
				$this->render('lecview',array(
				'model'=>$this->loadModel($id),
				'usc'=>$usc,
				'ucls'=>$ucls,
			));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Profile;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Profile']))
		{
			$model->attributes=$_POST['Profile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->uid));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUploadAvatar()
	{
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder='./'.Yii::app()->params['uploadFolder'].'/temp_upload/';// folder for uploaded files
        $allowedExtensions = array("jpg","png","gif");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        //resize and rename uploaded image
        Yii::import("ext.EPhpThumb.EPhpThumb");
		$thumb=new EPhpThumb();
		$thumb->init(); 
		$thumb->create('./'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$result['filename'])
		      ->resize(400,400)
		      ->save('./'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$result['filename']);
 
        echo $return;// it's array
	}


	public function actionCropAvatar(){
		Yii::import("ext.EPhpThumb.EPhpThumb");
		$thumb=new EPhpThumb();
		$thumb->init(); 
		$newFileName = './'.Yii::app()->params['uploadFolder'].'/temp_upload/'.time().$_POST['fname'];
		$thumb->create('./'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$_POST['fname'])
			  ->crop($_POST['cx'], $_POST['cy'], $_POST['cw'], $_POST['ch'])
			  ->resize(64,64)
			  ->save($newFileName);
	    if(file_exists($newFileName)){
	    	unlink('./'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$_POST['fname']);
	    	echo Yii::app()->request->baseUrl.substr($newFileName,1);
	    }else{
	    	echo 'fail';
	    }
	}

	public function actionGenerateAvatarFeed(){
		$cnews = News::model()->findByPk($_GET['id']);
		$cusr = LibUser::model()->findByPk($_GET['uid']);
		$this->renderPartial('avatar_timeline',array('cnews'=>$cnews,'cusr'=>$cusr));
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

		if(isset($_POST['Profile']))
		{
			$model->attributes=$_POST['Profile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->uid));
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
		$dataProvider=new CActiveDataProvider('Profile');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Profile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Profile']))
			$model->attributes=$_GET['Profile'];

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
		$model=Profile::model()->with('user_info')->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
