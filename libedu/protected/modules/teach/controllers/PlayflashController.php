<?php

class PlayflashController extends Controller
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
						'actions'=>array('index','view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('viewbymediaid','updateconvertrecord'),
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
	public function actionViewByMediaID( $mid )
	{
		$multimedia_model = Multimedia::model()->findByPk( $mid );
		if ( null == $multimedia_model ) {
			throw new CHttpException( 404 , "此文件已被删除");
		}
		$uid = Yii::app()->user->id;
		$flash_name = $multimedia_model->convert_name;
		$document_path = Yii::app()->params['uploadFolder'] . "/" . $uid . "/document/";
		$this->render('view_flash' , array( 
										'flash_file_path' => $document_path . $flash_name ) );		
	}
	public function actionUpdateConvertRecord( $mid , $converted_file_name )
	{		
		$multimedia_model = Multimedia::model()->findByPk( $mid );
		if ( null == $multimedia_model ) {
			throw new CHttpException( 404 , "没有此记录 : " . $mid );
		}
		$multimedia_model->convert_name = $converted_file_name;
		$multimedia_model->status       = Multimedia::STATUS_FINISHED;
		$multimedia_model->save();	
		echo("update success");	
	}
}