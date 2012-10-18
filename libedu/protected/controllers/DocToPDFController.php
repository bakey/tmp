<?php
require_once('protected/components/simple_html_dom.php');
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
						'actions'=>array('view','convert'),
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
	private function UpdatePostFlashLink( $post_id , $flash_name , $user_id )
	{
		$post_model = CoursePost::model()->findByPk( $post_id );
		if ( $post_model == null )
		{
			throw new CHttpException( 404 , "没有这篇post");
		}
		$html_dom = str_get_html( $post_model->post );
		echo CHtml::encode($html_dom);
	
		
		foreach( $html_dom->find('img[class=doc_placeholder]') as $node )
		{
			$parent = $node->parent();
			$node->outertext = '';
			$flash_path = 'http://' . Yii::app()->params['web_host'] . '/dev/libedu/bin_data/' . $user_id . '/document/' . $flash_name;
			$embed_str = sprintf( '<embed src="%s" width="650" height="500">' , $flash_path ) ;
			$parent->innertext = $embed_str;
		}
		$post_model->post = $html_dom->save();
		$post_model->save();
	}
	public function actionConvert()
	{
		$post_media_models = PostMedia::model()->findAll();
		foreach( $post_media_models as $post_media )
		{
			$mid = $post_media->mid;
			$uid = $post_media->uid;
			$media_model = Multimedia::model()->findByPk( $mid );
			$doc_name = $media_model->save_name;
			$waiting_convert_file_path = Yii::app()->params['uploadFolder'] . "/temp_upload/" . $uid . "/document/" . $doc_name;
			$target_file_path          = Yii::app()->params['uploadFolder'] . '/' . $uid . '/document/' . $doc_name . '.pdf';
			$command = Yii::app()->params['ppt_convert_command'] . $waiting_convert_file_path . " " . $target_file_path ;
			system( $command . " 2>&1", $retval ) ;
			$this->UpdatePostFlashLink( $post_media->post , $doc_name . '.pdf' ,  $uid );
			PostMedia::model()->deleteByPk( $mid );
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
			Yii::log( "convert to pdf error  " , 'error');
		}
		else
		{
			$msg = "convert success <br> command = " . $command ;
			echo( $msg );
			Yii::log( $msg , 'debug');		
			$this->updateConvertRecord( $mid , $main_name . ".swf" );
		}	
	}

	
}