<?php

class EditionController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionAdd()
	{
		$model = new CourseEdition;
		$this->performAjaxValidation($model);
		if(isset($_POST['CourseEdition']))
		{
			//var_dump( $_POST['CourseEdition'] );
			$model->name = $_POST['CourseEdition']['name'];
			$model->description = $_POST['CourseEdition']['description'];
			if ( $model->save() )
			{
				$this->redirect( array('edition/view') );
			}
			else {
				echo("save failed ");
			}
		}
		$this->render('add' , array('model'=>$model));		
	}
	public function actionAdmin()
	{
		$model=new CourseEdition('search');
		$model->unsetAttributes();
		$this->render('admin' , array('model'=>$model , ));
	}
	public function actionView()
	{
		$dataProvider=new CActiveDataProvider('CourseEdition',array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('view',array(
				'dataProvider'=>$dataProvider,
		));	
	}
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		/*$this->render('view',array(
				'model'=>$this->loadModel($id),
		));*/
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='edition-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function loadModel($id)
	{
		$model=CourseEdition::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}