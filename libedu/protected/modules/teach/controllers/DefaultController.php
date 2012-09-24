<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->layout="main";
		//$this->layoutPath = "ssdfs";
		$this->render('index');
	}
}