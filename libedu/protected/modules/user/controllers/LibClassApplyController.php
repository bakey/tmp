<?php

class LibClassApplyController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('apply','update','delete','approve'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
	public function actionApply()
	{
		$clslist = array();
		$model=new LibClassApply;
		$cusr = new LibUser;
		$usr = $cusr -> with('school_info')->findByPk(Yii::app()->user->getId());
		$ccls = new LibClass;
		foreach ($usr->school_info as $singleschool) {
			$clslist[$singleschool->name] = array();
			$res = $ccls->findAllByAttributes(array('school_id'=>$singleschool->id));
			foreach ($res as $singleclass) {
				$clslist[$singleschool->name][$singleclass->id]= $singleclass->name ;
			}
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['LibClassApply']))
		{
			$model->attributes=$_POST['LibClassApply'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->applicant));
		}

		$this->render('create',array(
			'model'=>$model,
			'classlist' => $clslist,
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

		if(isset($_POST['LibClassApply']))
		{
			$model->attributes=$_POST['LibClassApply'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->applicant));
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

	public function actionApprove($id){
		$crec = $this->loadModel($id);
		$uc = new LibUserClass;
		$uc->student_id = $crec->applicant;
		$uc->teacher_id = $crec->approver;
		$uc->class_id = $crec->class_id;
		if($uc->save()){
			$this->loadModel($id)->delete();
		}

		$this->redirect(array('/user/libclassapply/index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LibClassApply',array(
			'criteria'=>array(
		        'condition'=>'approver='.Yii::app()->user->getId(),
		        'with'=>array('class_info'),
	    	))
		);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LibClassApply('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LibClassApply']))
			$model->attributes=$_GET['LibClassApply'];

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
		$model=LibClassApply::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lib-class-apply-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
