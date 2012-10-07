<?php

class DocToPDFController extends Controller
{
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('test'),
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
	private function doConvert( $file_path , $file_name )
	{
		$parts = explode( '.' , $file_name );
		if ( count($parts) < 2 ) {
			die("invalid file name : " . $file_name );
		}
		$main_name = $parts[0];
		$suffix = $parts[1];
		$swf_name = $main_name . ".swf";
		$command = "\"E:\OpenOffice.org 3\program\python\" E:\wamp\www\py_convert\DocumentConverter.py " . $file_path . "/" . $file_name . " " . $swf_name ;
		$retval = "";
		if ( !system( $command . " 2>&1", $retval ) )
		{
			die("convert to pdf error !! " . $retval );
		}
		else
		{
			echo("convert success <br> command = " . $command  );
		}		
	}
	private function updateConvertRecord( $mid , $converted_file_name )
	{
		$multimedia_model = Multimedia::model()->findByPk( $mid );
		if ( null == $multimedia_model ) {
			throw new CHttpException( 404 , "没有此记录 : " . $mid );
		}
		$multimedia_model->convert_name = $converted_file_name;
		$multimedia_model->status       = Multimedia::STATUS_FINISHED;
		return $multimedia_model->save();
	}
	public function actionConvert( $file_path , $file_name , $media_id )
	{
		$parts = explode( '.' , $file_name );
		if ( count($parts) < 2 ) {
			die("invalid file name : " . $file_name );
		}
		$main_name = $parts[0];
		$suffix = $parts[1];
		$swf_path_name = $main_name . ".swf";
		$command = Yii::app()->app()->params['ppt_convert_command'] . $file_path . "/" . $file_name . " " . $swf_file_path ;
		$retval = "";
		if ( !system( $command . " 2>&1", $retval ) )
		{
			die("convert to pdf error !! " . $retval );
		}
		else
		{
			echo("convert success <br> command = " . $command  );
		}
		
		
	}

	public function actionTest( $file_name , $mid )
	{
		$parts = explode( '.' , $file_name );
		if ( count($parts) < 2 ) {
			die("invalid file name : " . $file_name );
		}
		$main_name = $parts[0];
		$suffix = $parts[1];
		$uid = Yii::app()->user->id;
		
		$doc_file_path = Yii::app()->params['uploadFolder'] . "/" . $uid . "/document/" . $file_name ;
		$swf_file_path = Yii::app()->params['uploadFolder'] . "/" . $uid . "/document/" . $main_name . ".swf";
		$command = Yii::app()->params['ppt_convert_command'] . $doc_file_path . " " . $swf_file_path ;
		$retval = "";
		system( $command . " 2>&1", $retval );
		if ( $retval != 0 )
		{
			//TODO , log convert error 
			die("convert to pdf error !! " . $retval );
		}
		else
		{
			echo("convert success <br> command = " . $command  );		
			$this->updateConvertRecord( $mid , $main_name . ".swf" );
		}	
	}

	
}