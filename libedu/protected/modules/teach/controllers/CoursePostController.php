<?php

class CoursePostController extends Controller
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
				'actions'=>array('admin','test','loadpostbyauthor','previewpost','reedit','autosave','viewbyid','drafttopublished','delete','create','update','upload'),
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
	public function actionViewDraft()
	{
	}
	public function actionViewPublished()
	{
		
	}
	public function actionViewById( $post_id , $course_id , $item_id )
	{
		$draft_to_publish_url = Yii::app()->createUrl("teach/coursepost/drafttopublished&post_id=$post_id&course_id=$course_id");
		$reedit_url = Yii::app()->createUrl("teach/coursepost/reedit&post_id=$post_id&course_id=$course_id");
		
		if ( LibUser::is_teacher() )
		{
			$this->renderPartial('teacher_view_post',array(
				'post_model'   => $this->loadModel($post_id),	
				'course_id'    => $course_id,  	
			));
		}
		else if ( LibUser::is_student() ) 
		{
			$this->renderPartial('student_view_post',array(
					'post_model'   => $this->loadModel($post_id),
					'course_id'    => $course_id,
			));			
		}		
	}
	public function actionTest()
	{
		/*echo CHtml::button('发布', array(
				'onClick'=>"window.location.href='www.baidu.com'",
				'',
		));*/
		var_dump( $this->if_image_file_suffix("Png"));
	}
	public function actionReEdit( $post_id , $course_id )
	{
		$post_model = CoursePost::model()->findByPk( $post_id );
		if ( null == $post_model ) {
			throw new CHttpException( 404 , "找不到这个post");
		}
		$user_id = Yii::app()->user->id;
		$course_model = Course::model()->findByPk( $course_id );
		$item_model      = $post_model->item;
		$relate_kps      = $item_model->relate_kps;
		$draft_posts 	 = CoursePost::model()->findAll( 'author = :user_id and item_id = :iid and status = :status_draft order by update_time desc' , array(
				':user_id' 		=> $user_id,
				':iid'     		=> $item_model->id,
				':status_draft' => Yii::app()->params['course_post_status_draft'],
		) );
		
		$baseCreateUrl = Yii::app()->createAbsoluteUrl('teach/coursepost/create&item_id=' . 
								$post_model->item_id . '&post_id='.$post_id.'&course_id='.$course_id);
		$baseAutoSaveUrl = Yii::app()->createAbsoluteUrl('teach/coursepost/autosave&item_id=' . 
								$post_model->item_id . '&post_id=' . $post_id );
		$this->render('create' , array(
				'model'           => $post_model,
				'course_model'    => $course_model,
				'course_id'       => $course_id,
				'base_auto_save_url' => $baseAutoSaveUrl,
				'base_create_url'    => $baseCreateUrl,
				'item_model'      => $post_model->item,
				'relate_kp_models' => $relate_kps,
				'draft_posts'   => $draft_posts,
				) );
		
	}
	public function actionDraftToPublished( $post_id , $item_id )
	{
		$course_id = Yii::app()->user->course;
		$post_model = CoursePost::model()->findByPk( $post_id );
		if ( null == $post_model ) {
			throw new CHttpException(404 , "no this post ");
		}
		$post_model->status = Yii::app()->params['course_post_status_published'];
		if ( $post_model->save() ){
			$this->redirect( array('index','item_id'=>$item_id , 'course_id'=>$course_id) );
		}	
		else {
			throw new CHttpException( 500 , "internal server error ");
		}
	}
	private function getTempCoursePostPath( $uid ) {
		if ( null == $uid ) {
			return null;
		}
		return Yii::app()->params['uploadFolder'] . "/" . $uid . '/coursepost/';		
	}
	private function getThumbPath( $uid ) {
		if ( null == $uid ) {
			return null;
		}
		return Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/thumb/';
	}
	private function if_image_file_suffix( $suffix )
	{
		$image_file_suffix_set = array( "jpg" , "png" , "gif" , "bmp" , "jpeg");
		return in_array( strtolower($suffix) , $image_file_suffix_set );		
	}
	private function if_document( $suffix )
	{
		$str = strtolower( $suffix );
		return $str == "vnd.ms-powerpoint" || $str == "vnd.openxmlformats-officedocument.presentationml.presentation";		
	}

	private function getOriginPath( $uid ) {
		if ( null == $uid ) {
			return null;
		}
		return Yii::app()->params['uploadFolder'].'/temp_upload/' . $uid . '/origin/';
	}
	private function getDocumentPath( $uid ) 
	{
		return Yii::app()->params['uploadFolder'] . "/temp_upload/" . $uid . "/document/";
	} 
	private function getSaveDocPath( $uid )
	{
		return Yii::app()->params['uploadFolder'] . '/' . $uid . '/document/';
	}

	private function getThumbImageUrl( $file_name , $uid ) {
		if ( null == $file_name || null == $uid ) {
			return null;
		}
		return Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				$this->getThumbPath($uid) . $file_name;
	}
	private function getOriginImageUrl( $file_name , $uid ) {
		if ( null == $file_name || null == $uid ) {
			return null;
		}
		return Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" .
				$this->getOriginPath($uid) . $file_name;
	}
	private function getDocumentUrl( $file_name , $uid ) 
	{
		return Yii::app()->request->hostInfo . Yii::app()->getBaseUrl(). "/" . $this->getDocumentPath($uid) . $file_name ;
		
	}
	/*
	 * 为用户保存发布的课程资料。
	 * 课程资料的状态可以从草稿变成已发布，也可以从已发布变成草稿
	 */
	private function saveCoursePost( $course_post_model , $item_id , $status , $post_id ) 
	{		
		$course_post_model->post = $_POST['CoursePost']['post'];
		$course_post_model->title = $_POST['CoursePost']['post_title'];
		$course_post_model->author = Yii::app()->user->id;
		$course_post_model->item_id = $item_id ;
		$course_post_model->status = $status ;
		if ( null != $post_id )
		{
			$course_post_model->update_time = date("Y-m-d H:i:s", time() ); 
			$save_res = $course_post_model->updateByPk( $post_id , array(
					'post'  => $_POST['CoursePost']['post'],
					'title' => $_POST['CoursePost']['post_title'],
					'status'=> $status,
					)) ;
			if ( $save_res >= 0 ) {
				return $post_id;
			}
			else {
				return -1;
			}
		}else {
			$course_post_model->create_time = $course_post_model->update_time = date("Y-m-d H:i:s", time() );
			$save_res = $course_post_model->save();
			if ( $save_res ) {
				return $course_post_model->id;
			}		
			else {
				return -1;
			}
		}
	}
	private function savePostMediaRelation( $post_id )
	{
		if ( !isset($_POST['mid']) ) {
			return ;
		}
		$mids = $_POST['mid'];
		foreach( $mids as $mid )
		{
			$post_media = new PostMedia;
			$post_media->post = $post_id;
			$post_media->mid = $mid;
			$post_media->uid = Yii::app()->user->id;
			$post_media->save();
		}
	}
	private function updateCoursePostRecord( $item_id , $post_id )
	{
		$course_post_model = new CoursePost;
		$status = CoursePost::STATUS_DRAFT;
		$course_post_model->post = $_POST['data'];
		$course_post_model->author = Yii::app()->user->id;
		$course_post_model->item_id = $item_id;
		$course_post_model->status = $status;
		//$course_post_model->update_time = date( "Y-m-d H:i:s", time() );
		return $course_post_model->updateByPk( $post_id , array(
					'post' => $_POST['data'],
					'update_time' => date( "Y-m-d H:i:s", time() ),
					) );
	}
	private function get_next_top_level_item( $current_item_id )
	{
		$item_model = Item::model()->findByPk( $current_item_id );
		$edition_id = $item_model->edition;
		$this_level_items = Item::model()->findAll( 'edition=:eid and level = 1 order by edi_index ' , array( ':eid' => $edition_id ) );
		$n = count($this_level_items);
		for( $i = 0 ; $i < $n ; ++ $i )
		{
			if ( $item_model->edi_index == $this_level_items[$i]->edi_index )
			{
				if ( $i < $n-1 ) {
					//如果第一层的item后面还有更多，那么返回下一个item的id
					return $this_level_items[ $i+1 ]->id;
				}
				else {
					//否则就返回当前这个item id就行了
					return $current_item_id;
				}
			}
		}		
	}
	private function get_first_sub_item( $current_item_id )
	{
		$current_item_model = Item::model()->findByPk( $current_item_id );
		$sub_items_data = new CArrayDataProvider( $current_item_model->level_child , array(
				'sort'=>array(
						'defaultOrder' => 'edi_index',
				)
		));
		$sub_items = $sub_items_data->getData();
		$n = count( $sub_items );
		if ( $n == 0 ) {
			return -1 ;
		}
		else {
			return $sub_items[0]->id;
		}
		
	}
	private function moveTracingItem( $save_item_id )
	{
		$save_item = Item::model()->findByPk( $save_item_id );
		//当前跟踪的model
		$tracing_info_model = TeacherItemTrace::model()->findByPk( Yii::app()->user->id );
		
		//当前tracing的一层item和它的所有子item，并把所有子item按照edi_index排列.
		$tracing_item = Item::model()->findByPk( $tracing_info_model->item );
		$sub_items_data = new CArrayDataProvider( $tracing_item->level_child , array(
				'sort'=>array(
						'defaultOrder' => 'edi_index',
					  )					
				));
		$sub_items = $sub_items_data->getData();
		$n = count( $sub_items );		
		for( $i = 0 ; $i < $n ; ++ $i )
		{
			if ( $sub_items[$i]->id == $save_item->id ) {
				if ( $i == $n-1 ) {
					/*
					 * 如果已经到了最后一个item，则跳到后面一个大item，否则就不需要变
					*/
					$current_item = $tracing_info_model->item ;
					$tracing_info_model->item = $this->get_next_top_level_item( $current_item );
					$tracing_info_model->save();
				}
			}
		}
		
	}
	private function process_course_post_submit( $course_post_model , $item_id , $course_id )
	{
		$user_id = Yii::app()->user->id;
		$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null ;

		if ( isset( $_POST['draft']) || isset( $_POST['preview']) )
		{
			$status = CoursePost::STATUS_DRAFT;
			$new_post_id =  $this->saveCoursePost($course_post_model , $item_id , $status , $post_id) ;
			if ( $new_post_id > 0 )
			{
				$this->savePostMediaRelation( $new_post_id );
				
				if ( isset( $_POST['draft']) ) 
				{
					$this->redirect(array('index','item_id' => $item_id ));
				}
				else
				{
					$post_model = CoursePost::model()->findByPk( $post_id );
					$item_model = Item::model()->findByPk( $item_id );
					$this->redirect( array('previewpost' , 'post_id' => $new_post_id ) );
				}
			}
			else 
			{
				throw new CHttpException( 400 , "更新数据库错误，该课程资料已经被删除");
			}			
		}
		else if ( isset($_POST['cancel']) )
		{
			$msg = sprintf("User cancel edit course post , user_id = %d , course id = %d" , $user_id , $course_id );			
			Yii::log( $msg , 'debug' );
			$this->redirect( array('coursepost/index&item_id=' . $item_id) );
		}
		else if ( isset($_POST['publish']) )
		{
			$msg = sprintf("publish the post ");
			Yii::log( $msg , 'debug' );
			$status = CoursePost::STATUS_PUBLISH;
			$new_post_id =  $this->saveCoursePost($course_post_model , $item_id , $status , $post_id) ;
			if( $new_post_id > 0 ) 
			{
				if ( LibUser::is_teacher() )
				{
					$this->moveTracingItem( $item_id );
				}
				$this->savePostMediaRelation( $new_post_id );
				$this->redirect(array('index', 'item_id'=>$item_id));
			}
			else 
			{
				throw new CHttpException( 400 , "更新数据库错误，该课程资料已经被删除");
			}
		}
		else {
			$msg = sprintf("user submit unknown data ");
			Yii::log( $msg , 'debug' );
			return;
		}		
	}
	private function getCoursePostAsStudent( $item_id )
	{
		$course_id = Yii::app()->user->course;
		$user_course_model = UserCourse::model()->find( 'course_id=:cid and role=:teacher_role' , 
															array( ':cid'=>$course_id , 
																	':teacher_role' => Yii::app()->params['user_role_teacher']) );
		
		$stu_post_data = new CActiveDataProvider( 'CoursePost' , array(
					'criteria' => array(
							'condition' => ( 'author=1'/*sprintf('author=%d and item_id=%d' , $user_course_model->user_id , $item_id)*/ ),
							'order'     => 'update_time DESC'
							),
					'pagination'=>array(
							'pageSize'=>15,
					)
				) );
		return $stu_post_data ;
	}
	private function get_relate_kp( $item_id )
	{
		$relate_kp_models = ItemKp::model()->findAll( 'item=:iid' , array(':iid'=>$item_id) );
	}
	private function process_document( $save_origin_doc_folder , $former_name , $save_name , $doc_folder , $item_id )
	{
		copy( $_FILES['file']['tmp_name'] , $doc_folder . $save_name );
		//保存一份原始的文档，供用户下载
		copy( $_FILES['file']['tmp_name'] , $save_origin_doc_folder . $former_name );
		$multimedia = new Multimedia;
		$multimedia->type 		 = Multimedia::TYPE_PPT;
		$multimedia->former_name = $former_name;
		$multimedia->save_name 	 = $save_name;
		$multimedia->uploader 	 = Yii::app()->user->id;
		$multimedia->status 	 = Multimedia::STATUS_PROCESSING; //默认所有文档的初始状态都是处理中
		$multimedia->item 		 = $item_id;
		$multimedia->upload_time = date( "Y-m-d H:i:s", time() );
		$multimedia->save();	
		return $multimedia;	
	}
	private function renderTeacherPostIndex( $cur_user  , $item_model )
	{
		$item_id = $item_model->id;
		$my_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'condition'=> ('author='.$cur_user.' and item_id='.$item_id . ' and status = ' . Yii::app()->params['course_post_status_published']),
						'order'    => 'update_time DESC',
				),
				'pagination' => false, 
		));
		$other_teacher_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'join'      => 'join tbl_user_course on author = tbl_user_course.user_id',
						'condition' => ( 'tbl_user_course.role=' . Yii::app()->params['user_role_teacher'] . ' and author !='.$cur_user.' and item_id='.$item_id ),
						'order'     => 'update_time DESC',
				),
				'pagination' => false,
		));
		$student_post_data = new CActiveDataProvider( 'CoursePost' , array(
				'criteria' => array(
						//'join'      => 'join tbl_user_course on tbl_course_post.author = tbl_user_course.user_id',
						'join'      => 'join tbl_user_course on author = tbl_user_course.user_id',
						'condition' => ( 'tbl_user_course.role=' . Yii::app()->params['user_role_student'] . ' and item_id='.$item_id ),
						'order'     => 'update_time DESC',						
				),
				'pagination' => false,
		));
		$this->render('index_teacher_coursepost',array(
				'self_post_data'     => $my_post_data ,
				'other_teacher_data' => $other_teacher_post_data,
				'student_post_data'  => $student_post_data, 
				'item_model'  	     => $item_model,
				'course_id'   		 => Yii::app()->user->course,
		));		
	}
	private function renderStudentPostIndex( $cur_user , $item_model )
	{
		$item_id       = $item_model->id;
		$course_model  = Course::model()->findByPk( Yii::app()->user->course ); 
		$teacher_model = $course_model->getCourseTeacher();
		
		$course_teacher_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'condition'=> ('author=:uid and item_id=:iid and status=:status' ),
						'params'   => array( ':uid' => $teacher_model->id , 
											  ':iid' => $item_id , 
											  ':status' => Yii::app()->params['course_post_status_published'] ),
						'order'    => 'update_time DESC',
				),
				'pagination' => false,
		));
		$other_teacher_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'join'      => 'join tbl_user_course on author = tbl_user_course.user_id',
						'condition' => ( 'tbl_user_course.role=:role and author != :uid and item_id=:iid' ),
						'params'    => array( ':role' => Yii::app()->params['user_role_teacher'] , 
											   ':uid' => $teacher_model->id  , 
											   ':iid' => $item_id ),
						'order'     => 'update_time DESC',
				),
				'pagination' => false,
		));
		$my_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'condition'=> ('author=:uid and item_id=:iid and status=:status' ),
						'params'   => array( ':uid' => $cur_user ,
											  ':iid' => $item_id ,
											  ':status' => Yii::app()->params['course_post_status_published'] ),
						'order'    => 'update_time DESC',
				),
				'pagination' => false,
		));
		$other_student_post_data = new CActiveDataProvider( 'CoursePost' , array(
				'criteria' => array(
						'join'      => 'join tbl_user_course on author = tbl_user_course.user_id',
						'condition' => ( 'tbl_user_course.role=:role and item_id=:iid and author != :uid and status=:status'  ),
						'params'    => array( ':role' => Yii::app()->params['user_role_student'] , 
											   ':iid'  => $item_id ,		
											   ':uid'  => $cur_user,
											   ':status' => Yii::app()->params['course_post_status_published'],
								),
						'order'     => 'update_time DESC',
				),
				'pagination' => false,
		));
		$this->render('index_student_coursepost',array(
				'course_teacher_post_data'    => $course_teacher_post_data,
				'other_teacher_post_data'     => $other_teacher_post_data ,
				'my_post_data'				  => $my_post_data,
				'other_student_post_data' 	  => $other_student_post_data,
				'item_model'  	     => $item_model,
				'course_id'   		 => Yii::app()->user->course,
		));
		
	}
	public function actionPreviewPost( $post_id )
	{
		$post_model = CoursePost::model()->findByPk( $post_id );
		$item_model = $post_model->item;
		$this->render('preview_post' , array( 'post_model' => $post_model , 'course_id' => Yii::app()->user->course , 'item_id' => $item_model->id ) );		
	}
	/*
	 * 获取某item下的某作者的所有post资料
	 */
	public function actionLoadPostByAuthor( $author , $item )
	{
		$post_models = CoursePost::model()->findAll( 'author=:uid and item_id=:iid' , array( ':uid' => $author , ':iid' => $item ) ) ;
		/* 
		$my_post_data = new CActiveDataProvider('CoursePost',array(
				'criteria'=>array(
						'condition'=> ('author='.$author.' and item_id='.$item ),
						'order'    => 'update_time DESC',
				),
				'pagination' => false,
		));	*/	
		$return_data = array();
		foreach( $post_models as $post )
		{
			$return_data[] = array( 'title' => $post->title , 'id' => $post->id );
		}
		//var_dump( $return_data );
		//exit();
		echo ( @json_encode( $return_data ) ); 
	}
	/*
	 * 处理用户上传二进制文件
	 */
	public function actionUpload( $item_id )
	{
		$uid = Yii::app()->user->id;
		
		if ( !isset($_FILES['file']['tmp_name']) ) {
			throw new CHttpException( 500 , "上传文件大小超过限制");
		}
		$former_file_name = $_FILES['file']['name'];
		$file_name = md5( $uid . $_FILES['file']['tmp_name'] ) . ".";
		$suffix = explode( '/' , $_FILES['file']['type'] );
		$file_name .= $suffix[1];
		
		//===================================================precheck the folder
		//存放原始图片的文件夹		
		$target_folder 				= $this->getOriginPath( $uid );
		//存放缩略图的文件夹
		$thumb_folder 				= $this->getThumbPath( $uid );
		//临时保存一下的文件夹，这下面的文件转换完成后就会被删
		$temp_doc_folder 			= $this->getDocumentPath( $uid );
		//保存原始文档的文件夹
		$save_origin_doc_folder 	= $this->getSaveDocPath( $uid );		
		if ( !@is_dir( $target_folder ) ) {
			mkdir( $target_folder , 0777 , true );
		}
		if ( !@is_dir( $thumb_folder ) ) {
			mkdir( $thumb_folder , 0777 , true );
		}
		if ( !@is_dir( $temp_doc_folder ) ) {
			mkdir( $temp_doc_folder , 0777 , true );
		}
		if ( !@is_dir( $save_origin_doc_folder) ) {
			mkdir( $save_origin_doc_folder , 0777 , true );
		}	
		//==============================================================
		
		$res_array = null;
		if ( $this->if_image_file_suffix($suffix[1]) )
		{
			copy( $_FILES['file']['tmp_name'] , $target_folder.$file_name );
			//如果为图片，需要进行处理		
			Yii::import("ext.EPhpThumb.EPhpThumb");
			$thumb=new EPhpThumb();
			$thumb->init();
			$thumb->create( $target_folder . $file_name )
				->resize(800,800)
				->save( $thumb_folder . $file_name );
		
			$image_thumb_url = $this->getThumbImageUrl( $file_name , $uid );
			$image_origin_url = $this->getOriginImageUrl($file_name, $uid);
			
			$res_array = array(
						'type'       => 1,
						'thumb_url'  => $image_thumb_url,
						'origin_url' => $image_origin_url,
						'image_class' => 'img-rounded',
						'upload_ret' => 'success',
					);
		
			echo CHtml::link( CHtml::image( $image_thumb_url,'', array('class'=>'img-rounded') ) , $image_origin_url );
		}
		else if ( $this->if_document($suffix[1]) )
		{				
			//把多文档的信息存进数据库，并返回一个相应的tbl_multimedia的model
			$doc_model = $this->process_document( $save_origin_doc_folder , $former_file_name , $file_name , $temp_doc_folder , $item_id );
			$res_array = array(
								 'type'       => 2, 
								 'result'	  => 'success' , 
								  'file_name' => $former_file_name , 
								  'url'		  => $this->getDocumentUrl($file_name,$uid),
								  'mid' 	  => $doc_model->id, 
					);
			echo @json_encode( $res_array );
		}	
	
		exit();	
	}
	public function actionAutoSave( $item_id )
	{
		$post_id = "";
		$save_res = false;
		$msg = "";
	
		
		if( isset($_POST['data']) )
		{
			if ( isset($_GET['post_id']) )
			{
				//更新操作,只有实质内容的才update
				$post_id = $_GET['post_id'];
				$save_res = $this->updateCoursePostRecord( $item_id , $post_id );
				$msg = "update post_id = " . $post_id ;
			}
			else
			 {
				//第一次保存，直接创建
				$msg = "create ";
				$course_post_model = new CoursePost;
				$status = CoursePost::STATUS_DRAFT;
				$course_post_model->post = $_POST['data'];
				$course_post_model->author = Yii::app()->user->id;
				$course_post_model->item_id = $item_id;
				$course_post_model->status = $status;
				$course_post_model->create_time = $course_post_model->update_time = date( "Y-m-d H:i:s", time() );
				$course_post_model->title = "临时保存title";
				$save_res = $course_post_model->save() > 0 ;	
				$post_id = $course_post_model->id;
			}
			$msg = " post record [ ";			
			if ( $save_res ) {
				$msg .= "success] ";
			}
			else {
				$msg .= "failed]";
			}
			echo( '({"post_id":"' . $post_id . '"})' );
		}				
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate( $item_id , $course_id )
	{
		$course_post_model = new CoursePost;
		$course_post_model->unsetAttributes();
		$user_id = Yii::app()->user->id;

		if( isset($_POST['CoursePost']) )
		{
			$this->process_course_post_submit( $course_post_model , $item_id , $course_id );
		}
		$item_model      = Item::model()->findByPk( $item_id ); 
		$course_model    = Course::model()->findByPk( $course_id );
		$relate_kps      = $item_model->relate_kps; 
		$baseAutoSaveUrl = Yii::app()->createAbsoluteUrl('teach/coursepost/autosave&item_id=' . $item_id);
		$base_create_url = Yii::app()->createAbsoluteUrl('teach/coursepost/create&item_id=' . $item_id . '&course_id='.$course_id . '&post_id=' );
		$draft_posts 	 = CoursePost::model()->findAll( 'author = :user_id and item_id = :iid and status = :status_draft order by update_time desc' , array(
										':user_id' 		=> $user_id,
										':iid'     		=> $item_id,
										':status_draft' => Yii::app()->params['course_post_status_draft'],
								) );

		$this->render('create',array(
			'model'			   => $course_post_model,
			'item_model'	   => $item_model,
			'course_model'	   => $course_model,
			'relate_kp_models' => $relate_kps,
			'base_auto_save_url' => $baseAutoSaveUrl,
			'base_create_url'    => $base_create_url,
			'draft_posts'   => $draft_posts,
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

		if(isset($_POST['CoursePost']))
		{
			$model->attributes=$_POST['CoursePost'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete($post_id )
	{
		$this->loadModel($post_id)->delete();
		echo @json_encode( array('del_ret' => '1') );

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax'])) {
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index&item_id='.$item_id));
		//}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex( $item_id )
	{
		$cur_user = Yii::app()->user->id;

		$item_model = Item::model()->findByPk( $item_id );
		
		if ( LibUser::is_student() )
		{
			$this->renderStudentPostIndex( $cur_user , $item_model );
		}
		else if ( LibUser::is_teacher() )
		{
			$this->renderTeacherPostIndex( $cur_user , $item_model );		
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CoursePost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CoursePost']))
			$model->attributes=$_GET['CoursePost'];

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
		$model=CoursePost::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
