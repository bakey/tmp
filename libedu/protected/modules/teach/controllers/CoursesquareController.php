<?php

class CoursesquareController extends Controller
{
	public $layout = '//layouts/course_square_main';
	public function actionAdmin()
	{
		$this->render('admin');
	}

	public function actionIndex()
	{
		//$this->layout = '//layouts/course_square_main';
		$this->render('index');
	}

	public function actionTest()
	{
	
		$this->render('test');
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