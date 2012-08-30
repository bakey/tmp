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
	public function actionView()
	{
		$dataProvider=new CActiveDataProvider('CourseEdition',array(
				'pagination'=>array('pageSize'=>15),
		));
		$this->render('view',array(
				'dataProvider'=>$dataProvider,
		));	
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='edition-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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