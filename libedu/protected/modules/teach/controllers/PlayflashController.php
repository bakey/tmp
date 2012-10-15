<?php
require_once('protected/components/simple_html_dom.php');
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
						'actions'=>array('viewbymediaid','updateconvertrecord' , 'updatepostflashlink'),
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
		$this->render('view_flash' , array( 'flash_file_path' => $document_path . $flash_name ) );		
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
	public function actionUpdatePostFlashLink( $post_id , $flash_name , $user_id )
	{
		$post_model = CoursePost::model()->findByPk( $post_id );
		if ( $post_model == null )
		{
			throw new CHttpException( 404 , "没有这篇post");
		}
		$html_dom = str_get_html( $post_model->post );
		foreach( $html_dom->find('img[class=doc_placeholder]') as $node )
		{
			$parent = $node->parent();
			$node->outertext = '';
			$flash_path = 'http://' . Yii::app()->params['web_host'] . '/dev/libedu/bin_data/' . $user_id . '/document/' . $flash_name;
			$embed_str = sprintf( '<object width="420" height="363"><param name="movie" value="%s"></param> \
					<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param> \
					<param name="wmode" value="opaque"></param> \
					<embed src="%s" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="420" height="363"></embed> \
					</object>' , $flash_path , $flash_path ) ;
			$parent->innertext = $embed_str;
		}
		$post_model->post = $html_dom->save();
		$post_model->save();
		echo ( "update success" );		
	}
}