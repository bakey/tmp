<?php

class LibClassController extends Controller
{
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
				'actions'=>array('create','getclassstudent','update','admin','viewstudent'),
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
	
	public function actionGetClassStudent()
	{
		if ( isset( $_POST['class']) )
		{
			$class_id = $_POST['class'];
			$class_model = $this->loadModel( $class_id );
			$students = $class_model->class_student;
			$student_info = array();
			foreach( $students as $student )
			{
				$profile = $student->user_profile;
				$info = array(
						'id' => $student->id,
						'name' => $profile->real_name,
				);
				
				$user_school_set = $student->unique_id;
				foreach( $user_school_set as $us )
				{
					if ( $us->school_id == Yii::app()->params['currentSchoolID'] )
					{
						$info['school_unique_id'] = $us->school_unique_id;
						break;
					}
				}				
				$student_info[] = $info;				
			}
			$dataProvider = new CArrayDataProvider( $student_info );
			$this->renderPartial( 'view_student' , array(
					'dataProvider' => $dataProvider,
					) );
		}
		//$this->render( 'view_student' , array() );		
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
		$model=new LibClass;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LibClass']))
		{
			$model->attributes=$_POST['LibClass'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$tlist = UserSchool::model()->findAllByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID'],'role'=>2));
		$res = array('-1'=>'不指定');
		foreach($tlist as $singlet){
			$tuser = LibUser::model()->findByPk($singlet->user_id);
			$res[$tuser->id]=$tuser->user_profile->real_name;	
		}

		$this->render('create',array(
			'model'=>$model,
			'tinfo'=>$res,
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

		if(isset($_POST['LibClass']))
		{
			$model->attributes=$_POST['LibClass'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$tlist = UserSchool::model()->findAllByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID'],'role'=>2));
		$res = array('-1'=>'不指定');
		foreach($tlist as $singlet){
			$tuser = LibUser::model()->findByPk($singlet->user_id);
			$res[$tuser->id]=$tuser->user_profile->real_name;	
		}

		$this->render('update',array(
			'model'=>$model,
			'tinfo'=>$res,
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
		$dataProvider=new CActiveDataProvider('LibClass');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionViewStudent( $class_id )
	{
		$class_model = $this->loadModel( $class_id );
		$students = $class_model->class_student;
		$student_info = array();
		foreach( $students as $student )
		{
			$info = array();
			$profile = $student->user_profile;
			if ( null == $profile ) {
				throw new CHttpException( 400 , "user : " . $student->id . " no profile ");
			}
			$info['id'] = $student->id;
			$info['name'] = $profile->real_name;
			$user_school_set = $student->unique_id;
			foreach( $user_school_set as $us )
			{
				if ( $us->school_id == Yii::app()->params['currentSchoolID'] )
				{
					$info['school_unique_id'] = $us->school_unique_id;
					break;					
				}				
			}
			$student_info[] = $info;			
		}
		$dataProvider = new CArrayDataProvider( $student_info );
		$this->render( 'view_student' , array(
				'dataProvider'=>$dataProvider,
				));		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout = '//layouts/column1';		
		$uid = Yii::app()->user->id;		
		$user_model = LibUser::model()->findByPk( $uid );
		$classes = $user_model->teacher_class;
		$class_data = array();
		
		foreach( $classes as $lib_class )
		{
			$item = array();
			$item['name'] = $lib_class->name;
			$item['id'] = $lib_class->id;
			$class_data[] = $item;			
		}
		$dataProvider=new CArrayDataProvider( $class_data , array(
				'pagination'=>array(
						'pageSize'=>15,
					),
				));
	

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LibClass::model()->findByPk($id);
		if($model===null) {
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lib-class-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
