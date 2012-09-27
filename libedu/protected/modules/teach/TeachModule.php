<?php

class TeachModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'teach.models.*',
			'teach.components.*',
		));
		//$this->layoutPath = Yii::getPathOfAlias('teach.views.layouts');
		//$this->layout = '//layouts/online_column';
		/*$this->layoutPath = Yii::getPathOfAlias('teach.views.layouts');*/
		//$this->layoutPath="protected/modules/teach/views/layouts";
	//	CController::$layout = '//layouts/teach_column';
		//$this->layout = 'application.modules.teach.main';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else {
			return false;
		}
	}
}
