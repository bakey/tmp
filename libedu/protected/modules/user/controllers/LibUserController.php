<?php

class LibUserController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LibUser',array(
			'criteria'=>array(
			),
			'pagination'=>array('pageSize'=>15),
		));
		$this->render('index',array(
			'dProvider'=>$dataProvider,
		));
	}

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    public function actionHome(){
    	$this->layout = 'usercentertwocolumn';
    	$this->render('userhome');
    }

    public function actionTeacherAdmin(){
    	$nocourseProvider=new CActiveDataProvider('LibUser',array(
			'criteria'=>array(
				'select'=>'t.id,tbl_profile.real_name,t.email,tbl_user_school.role',
				'join'=>'LEFT JOIN tbl_user_course ON t.id = tbl_user_course.user_id INNER JOIN tbl_profile ON t.id = tbl_profile.uid INNER JOIN tbl_user_school ON t.id = tbl_user_school.user_id',
				'condition'=>'tbl_user_school.role = 2 AND tbl_user_school.leave_time IS NULL AND tbl_user_school.school_id = '.Yii::app()->params['currentSchoolID'],
				'having'=>'COUNT(tbl_user_course.course_id) < 1',
				'group'=>'t.id',
				'order'=>'tbl_user_school.join_time DESC'
			),
			'pagination'=>array('pageSize'=>5),
		));

		$nojoinProvider=new CActiveDataProvider('UserActive',array(
			'criteria'=>array(
				'condition'=>'t.class_id IS NULL AND t.school_id = '.Yii::app()->params['currentSchoolID'],
				'order'=>'create_time DESC',
			),
			'pagination'=>array('pageSize'=>5),
		));

		$joined = UserSchool::model()->findAllByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID'],'role'=>2));
		

    	$this->render('teacheradmin',array('nocourseProvider'=>$nocourseProvider,'nojoinProvider'=>$nojoinProvider,'joined'=>$joined));	
    }

	public function actionGetTimeline($uid){
		$cnews = News::model()->findAllByAttributes(array('user'=>Yii::app()->user->id));
		if($cnews){
			foreach($cnews as $singlenews){
				$_GET['id']=$singlenews->id;
				$_GET['rid']=$singlenews->resource_id;
				$_GET['uid']=$uid;
				$this->forward('/user/news/getresource',false);
			}
		}
	}

	public function actionIForgot($status = 2){
		$model = new LibUser;
		$form = new CForm('application.modules.user.views.LibUser.iForgotForm', $model);
		if($form->submitted('resendBtn')){
			if(LibUser::model()->sendResetPasswordEmail($_POST['LibUser']['email'])){
				$this->redirect(array('/user/libuser/iforgot','status'=>1));
			}else{
				$this->redirect(array('/user/libuser/iforgot','status'=>0));
			}
		}else{
			if($status == 1){
				$this->render('iforgotresult',array('msg' => '系统已经重新给您发送了一封电子邮件，请您检查您的邮箱，点击邮件中的链接以重置密码。'));
			}else if($status == 0){
				$this->render('iforgot',array('msg' => '系统中没有您的电子邮箱地址，请您再次确认您输入的是您注册时填写的电子邮件地址','form'=>$form));
			}else if($status == 2){
				$this->render('iforgot', array('form'=>$form));
			}
		}
	}

	public function actionClassStuStatus(){
		if(isset(Yii::app()->user->urole)){
			if(Yii::app()->user->urole == 2){
				$ccls = LibClass::model()->findByAttributes(array('classhead_id'=>Yii::app()->user->id));
				if(!$ccls){
					$this->render('_classstuinfo',array('notclasshead'=>true),false,true);
				}else{
					$cid = $ccls->id;
					$notin = UserActive::model()->findAllByAttributes(array('class_id'=>$cid));
					$alreadyin = LibUserClass::model()->findallbyattributes(array('class_id'=>$cid,'teacher_id'=>$ccls->classhead_id));
					$ttl = 0;
					$resarray = array();
					foreach($notin as $singlenotin){
						$ttl++;
						$resarray[$ttl]['学号'] = $singlenotin->school_unique_id;
						$resarray[$ttl]['姓名'] = $singlenotin->name;
						$resarray[$ttl]['状态'] = '未注册';
					}
					foreach($alreadyin as $singlealreadyin){
						$ttl++;
						foreach($singlealreadyin->student_info->unique_id as $singleunique){
							if($singleunique->school_id == Yii::app()->params['currentSchoolID']){
								$resarray[$ttl]['学号'] = $singleunique->school_unique_id;
							}
							break;
						}
						$resarray[$ttl]['姓名'] = $singlealreadyin->student_info->user_profile->real_name;
						if($singlealreadyin->student_info->status == 2){
							$resarray[$ttl]['状态'] = '已加入并激活';		
						}else{
							$resarray[$ttl]['状态'] = '已加入未激活';
						}
					}
					$dataProvider=new CArrayDataProvider($resarray, array(
					    'id'=>'loadeduser',
					    'keyField'=>'学号',
					    'sort'=>array(		    	
					        'attributes'=>array(
					             '姓名','学号', '状态'
					        ),
					    ),
					));
					$this->render('_classstuinfo',array('dataProvider'=>$dataProvider,'classname'=>$ccls->name),false,true);
				}
			}else{
				$this->render('_classstuinfo',array('notclasshead'=>true),false,true);	
			}
		}else{
			$this->render('_classstuinfo',array('notclasshead'=>true),false,true);
		}
	}

	public function actionNotActived(){
		$this->render('noactive',array('uemail'=>Yii::app()->User->uemail));
	}

	public function actionChangePassword($id){
	    $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	    $err = -3;
		if(isset($_POST['LibUser']))
		{	
			$cusr=LibUser::model()->findByPk($id);
			if(md5($_POST['LibUser']['oldpassword'].$cusr->salt) == $cusr->password){
				if($_POST['LibUser']['password']==$_POST['LibUser']['repeatpassword']){
					if($_POST['LibUser']['password']!=''){
						$cusr->password = md5($_POST['LibUser']['password'].$cusr->salt);
						$cusr->save(false);
						$err = 1;
					}else{
						$err = -1;
					}
				}else{
					$err = -2;
				}
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'msg'=>$err,
		));
	}

	public function actionResetPassword($aid,$uid){
	     $model=$this->loadModel($uid);
	    if(LibUser::model()->validateResetPassword($aid,$uid)){
	    	$err = -3;
			if(isset($_POST['LibUser']))
			{	
				$cusr=LibUser::model()->findByPk($uid);
				if($_POST['LibUser']['password']==$_POST['LibUser']['repeatpassword']){
					if($_POST['LibUser']['password']!=''){
						$cusr->password = md5($_POST['LibUser']['password'].$cusr->salt);
						$cusr->save(false);
						$err = 1;
						TempActive::model()->deleteAllByAttributes(array('active_id'=>$aid));
						$this->render('iforgotresult',array('msg' => '密码重置成功，请用您新设置的密码登陆系统！'));
						exit();
					}else{
						$err = -1;
						$this->render('resetpwd',array(
						'model'=>$model,
						'msg'=>$err,
						));
					}
				}else{
					$this->render('resetpwd',array(
					'model'=>$model,
					'msg'=>$err,
					));
				}
			}
			$this->render('resetpwd',array(
					'model'=>$model,
					'msg'=>$err,
					));
	    }else{
	    	$this->render('iforgotresult',array('msg' => '验证码错误或已过期！'));
	    }
	}

	public function actionRegister(){
		$model = new LibUser;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['LibUser']))
		{
			$model->attributes=$_POST['LibUser'];
			if($model->save()){
				$this->redirect(array('/site/login'));
			}				
		}

		$csch = new LibClass;
		$finalres = array();
		$res = $csch->findAllByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID']));
		foreach($res as $singleres){
			$finalres[$singleres->id] = $singleres->name;
		}
		$this->render('create',array(
			'model'=>$model, 'classlist'=>$finalres
			));
		
	}

	public function actionImportStudentList(){
		$this->render('importstuinfo');
	}

	public function actionDoImportStudentList(){
		Yii::import("ext.EAjaxUpload.qqFileUploader");
 
        $folder='./bin_data/temp_upload/';// folder for uploaded files
        $allowedExtensions = array("xls","xlsx");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
         echo $return;// it's array
	}

	//teacher relavent

	public function actionImportTeacherList(){
		$this->render('importlecinfo');
	}

	public function actionDoImportTeacherList(){
		Yii::import("ext.EAjaxUpload.qqFileUploader");
 
        $folder='./bin_data/temp_upload/';// folder for uploaded files
        $allowedExtensions = array("xls","xlsx");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
         echo $return;// it's array
	}

	public function actionLoadTeacherInfo(){
		$stuinfo = array();
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		$stuinfo = $this->getTeacherInfoFromExcelFile($fname);
		$stuinfo['stuinfo'] = LibUser::model()->validateTeacherFromArray($stuinfo['stuinfo'],$stuinfo['schoolid']);
		$dataProvider=new CArrayDataProvider($stuinfo['stuinfo'], array(
		    'id'=>'loadeduser',
		    'keyField'=>'序号',
		    'sort'=>array(
		        'attributes'=>array(
		             '姓名', '邮箱'
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>15,
		    ),
		));
		$this->renderPartial('_uploadedTeacherInfo', array('dataProvider'=>$dataProvider,'schoolname'=>$stuinfo['schoolname'],'schoolid'=>$stuinfo['schoolid']), false, true);
	}

	public function actionDoLoadTeacherInfo(){
		if(!isset($_REQUEST['fname'])){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		$stuinfo = $this->getTeacherInfoFromExcelFile($fname);
		if(!$stuinfo){
			echo '学生列表为空或文件读取错误，请再试一次！';
		}else{
			$importres = Libuser::model()->addTeacherFromArray($stuinfo['stuinfo'],$stuinfo['schoolid']);
			echo '<h4>教师列表导入结果</h4><ul>
				<li>总记录条数：<strong>'.$importres['total'].'</strong></li>
				<li>成功导入<strong>'.$importres['success'].'</strong>名教师</li>
				<li><strong>'.$importres['fail'].'</strong>名教师导入失败</li>
			</ul>';

		}
	}

	private function getTeacherInfoFromExcelFile($fname = null){
		if($fname == null){
			return array();
		}
		$stuinfo = array();
		$finalinfo = array();

		$filePath = './'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$fname;
		$applicationPath = Yii::getPathOfAlias('webroot');
		spl_autoload_unregister(array('YiiBase','autoload')); 
		require_once $applicationPath.'/protected/vendors/phpexcel/PHPExcel.php';
		spl_autoload_register(array('YiiBase','autoload'));
		if($fname != null){
			$PHPExcel = new PHPExcel(); 
		    $PHPReader = new PHPExcel_Reader_Excel2007(); 
			if(!$PHPReader->canRead($filePath)){ 
				$PHPReader = new PHPExcel_Reader_Excel5(); 
				if(!$PHPReader->canRead($filePath)){ 
					echo '无法读取文件'; 
					return ; 
				} 
			} 
			
			$PHPExcel = $PHPReader->load($filePath); 
			$currentSheet = $PHPExcel->getSheet(0); 
			
			$ttlColumn = $currentSheet->getHighestColumn(); 
			$ttlRow = $currentSheet->getHighestRow(); 

			$finalinfo['schoolname'] = $currentSheet->getCellByColumnAndRow(1,2)->getValue();
			$finalinfo['schoolid'] = $currentSheet->getCellByColumnAndRow(3,2)->getValue();  
			
			for($irow=4;$irow < $ttlRow; $irow++){
				for($icolumn=0;$icolumn<2;$icolumn++){
					if($currentSheet->getCellByColumnAndRow(1,$irow)->getValue() == ''){
						break 2;
					}
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(0,3)->getValue()] = $currentSheet->getCellByColumnAndRow(0,$irow)->getValue();
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(1,3)->getValue()] = $currentSheet->getCellByColumnAndRow(1,$irow)->getValue();			
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(3,3)->getValue()] = $currentSheet->getCellByColumnAndRow(3,$irow)->getValue();
				}
			}
			$finalinfo['stuinfo'] = $stuinfo;
		}else{
			echo '无法读取文件！';
		}
		return $finalinfo;
	}


	private function getStudentInfoFromExcelFile($fname = null){
		if($fname == null){
			return array();
		}
		$stuinfo = array();
		$finalinfo = array();

		$filePath = './'.Yii::app()->params['uploadFolder'].'/temp_upload/'.$fname;
		$applicationPath = Yii::getPathOfAlias('webroot');
		spl_autoload_unregister(array('YiiBase','autoload')); 
		require_once $applicationPath.'/protected/vendors/phpexcel/PHPExcel.php';
		spl_autoload_register(array('YiiBase','autoload'));
		if($fname != null){
			$PHPExcel = new PHPExcel(); 
		    $PHPReader = new PHPExcel_Reader_Excel2007(); 
			if(!$PHPReader->canRead($filePath)){ 
				$PHPReader = new PHPExcel_Reader_Excel5(); 
				if(!$PHPReader->canRead($filePath)){ 
					echo '无法读取文件'; 
					return ; 
				} 
			} 
			
			$PHPExcel = $PHPReader->load($filePath); 
			$currentSheet = $PHPExcel->getSheet(0); 
			
			$ttlColumn = $currentSheet->getHighestColumn(); 
			$ttlRow = $currentSheet->getHighestRow(); 

			$finalinfo['schoolname'] = $currentSheet->getCellByColumnAndRow(1,2)->getValue();
			$finalinfo['schoolid'] = $currentSheet->getCellByColumnAndRow(3,2)->getValue();  
			
			for($irow=4;$irow < $ttlRow; $irow++){
				for($icolumn=0;$icolumn<6;$icolumn++){
					if($currentSheet->getCellByColumnAndRow($icolumn,$irow)->getValue() == ''){
						break 2;
					}			
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow($icolumn,3)->getValue()] = $currentSheet->getCellByColumnAndRow($icolumn,$irow)->getValue();
				}
			}
			$finalinfo['stuinfo'] = $stuinfo;
		}else{
			echo '无法读取文件！';
		}
		return $finalinfo;
	}

	public function actionLoadStudentInfo(){
		$stuinfo = array();
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		$stuinfo = $this->getStudentInfoFromExcelFile($fname);
		$stuinfo['stuinfo'] = LibUser::model()->validateUserFromArray($stuinfo['stuinfo'],$stuinfo['schoolid']);
		$dataProvider=new CArrayDataProvider($stuinfo['stuinfo'], array(
		    'id'=>'loadeduser',
		    'keyField'=>'序号',
		    'sort'=>array(
		    	
		        'attributes'=>array(
		             '学号', '班级', '姓名', '班级ID','failreason'
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>15,
		    ),
		));
		$this->renderPartial('_uploadedStudentInfo', array('dataProvider'=>$dataProvider,'schoolname'=>$stuinfo['schoolname'],'schoolid'=>$stuinfo['schoolid']), false, true);
	}

	public function actionDoLoadStudentInfo(){
		if(!isset($_REQUEST['fname'])){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		$stuinfo = $this->getStudentInfoFromExcelFile($fname);
		if(!$stuinfo){
			echo '学生列表为空或文件读取错误，请再试一次！';
		}else{
			$importres = Libuser::model()->addUserFromArray($stuinfo['stuinfo'],$stuinfo['schoolid']);
			$importres['addedstuinfo']['schoolname'] = $stuinfo['schoolname'];
			Yii::app()->user->setState('addedstu',$importres['addedstuinfo']);
			echo '<h4>学生列表导入结果</h4><ul>
				<li>总记录条数：<strong>'.$importres['total'].'</strong></li>
				<li>成功导入<strong>'.$importres['success'].'</strong>名学生</li>
				<li><strong>'.$importres['fail'].'</strong>名学生导入失败</li>
			</ul><a href="'.Yii::app()->createUrl('/user/libuser/generatestudentinfocard').'">打印学生信息卡片</a>';

		}
	}

	public function actionGenerateStudentInfoCard(){
	    $criteria = new CDbCriteria();
		$criteria->compare('create_time', '>'.(time()-300));
		$dataProvider=new CArrayDataProvider(Yii::app()->user->addedstu, array(
		    'id'=>'loadeduser',
		    'keyField'=>'序号',
		    'sort'=>array(
		    	
		        'attributes'=>array(
		             '学号', '班级', '姓名', '班级ID'
		        ),
		    ),
		));
		if(!isset(Yii::app()->user->addedstu[1])){
			$this->render('_uploadedStudentInfoCard', array('dataProvider'=>$dataProvider,'schoolname'=>Yii::app()->user->addedstu['schoolname'],'schoolid'=>Yii::app()->params['currentSchoolID'],'norecord'=>true), false, true);
		}else{
			$this->render('_uploadedStudentInfoCard', array('dataProvider'=>$dataProvider,'schoolname'=>Yii::app()->user->addedstu['schoolname'],'schoolid'=>Yii::app()->params['currentSchoolID']), false, true);
		}
		
	}

	public function actionResendActivationCode($status = 2){
		//未完成
		$model = new LibUser;
		$form = new CForm('application.modules.user.views.LibUser.resendForm', $model);
		if($form->submitted('resendBtn')){
			if(LibUser::model()->resendActivationCode($_POST['LibUser']['email'])){
				$this->redirect(array('/user/libuser/resendactivationcode','status'=>1));
			}else{
				$this->redirect(array('/user/libuser/resendactivationcode','status'=>0));
			}
		}else{
			if($status == 1){
				$this->render('resendresult',array('msg' => '系统已经重新给您发送了一封激活电子邮件，请您检查您的邮箱，点击邮件中的链接激活您的账户。'));
			}else if($status == 0){
				$this->render('resend',array('msg' => '系统中没有您的电子邮箱地址，请您再次确认您输入的是您注册时填写的电子邮件地址','form'=>$form));
			}else if($status == 2){
				$this->render('resend', array('form'=>$form));
			}
		}
	}	

	public function actionActivate($aid,$uid){
		if(LibUser::model()->validateActivationCode($aid,$uid)){
			$this->render('active',array(
				'msg'=>'账户激活成功！',
				'result' => 1,
			));
		}else{
			$this->render('active',array(
				'msg'=>'您的帐户激活码不正确或已过期！',
				'result' => 0,
			));
		}
	}

	public function actionLecActivate($aid,$sid){
		$newusr = new LibUser;
		$msg = '';
		if(isset($_POST['LibUser'])){
			if(LibUser::model()->validateLecActivationCode($aid)){
				if($_POST['LibUser']['password']!=$_POST['LibUser']['repeatpassword']){
					$msg.= '请确保两次输入的密码一致。';
				}else{
					$cua = UserActive::model()->findByAttributes(array('active_id'=>$aid));
					if($cua->name != $_POST['LibUser']['realname']){
						$msg.= '您的姓名不在系统中。';
					}else{
						$newusr->password = $_POST['LibUser']['password'];
						$newusr->email = $sid;
						$newusr->status = 2;
						$newusr->oldpassword = 'lectureractivation';
						$newusr->schooluniqueid = $sid;
						$newusr->realname = $_POST['LibUser']['realname'];
						if($newusr->save(false)){
							$this->render('active',array(
								'msg'=>'帐户设置已完成！',
								'result' => 1,
							));
							exit();		
						}
					}
				}
			}			
		}

		if(LibUser::model()->validateLecActivationCode($aid)){
			$this->render('lecactivesuccess',array(
				'msg'=>'账户激活成功！请填写以下信息以完成帐户设置。'.$msg,
				'result' => 1,
				'model' => new $newusr,
			));
		}else{
			$this->render('active',array(
				'msg'=>'您的帐户激活码不正确或已过期！',
				'result' => 0,
			));
		}
	}

	public function actionAddAdmin(){
		$newusr = new LibUser;
		$msg = '';
		$csc = School::model()->findByPk(Yii::app()->params['currentSchoolID']);

		if(isset($_POST['LibUser'])){
			if($_POST['LibUser']['password']!=$_POST['LibUser']['repeatpassword']){
				$msg.= '请确保两次输入的密码一致。';
			}else if(($_POST['LibUser']['email']=='')||($_POST['LibUser']['password']=='')||($_POST['LibUser']['repeatpassword']=='')||($_POST['LibUser']['realname']=='')){
				$msg.= '请确认填写全部项目';
			}
			else{
				//todo valid email format
				$res1= LibUser::model()->findByAttributes(array('email'=>$_POST['LibUser']['email']));
				if($res1){
					$msg.= '该邮箱地址已在系统中存在！';	
				}else{
					$newusr->password = $_POST['LibUser']['password'];
					$newusr->email = $_POST['LibUser']['email'];
					$newusr->status = 2;
					$newusr->oldpassword = 'addadmin';
					$newusr->schooluniqueid = $_POST['LibUser']['email'];
					$newusr->realname = $_POST['LibUser']['realname'];
					if($newusr->save(false)){
						$this->render('addadmin',array(
							'msg'=>'添加行政人员成功！',
							'result' => 1,
							'model' => new LibUser,
							'csc'=>$csc,
						));
						exit();		
					}
				}
			}
		}

		if($msg!=''){
			$this->render('addadmin',array(
				'result' => 1,
				'model' => new $newusr,
				'csc'=>$csc,
				'msg'=>$msg,
			));
		}else{
			$this->render('addadmin',array(
			'result' => 1,
			'model' => new $newusr,
			'csc'=>$csc,
		));
		}
	}

	public function actionInviteTeacher(){
		$model = new UserActive;

		//todo email address validation
		$form = new CForm('application.modules.user.views.LibUser.inviteTeacherForm', $model);
		if($form->submitted('resendBtn') && ($_POST['UserActive']['school_unique_id']!='')){
			$stuinfo = array('schoolid'=>Yii::app()->params['currentSchoolID'],'stuinfo'=>array(array('姓名'=>$_POST['UserActive']['name'],'邮箱'=>$_POST['UserActive']['school_unique_id'])));
			$res = LibUser::model()->addTeacherFromArray($stuinfo['stuinfo'],Yii::app()->params['currentSchoolID']);
			if($res['success'] < 1){
				$this->render('intiveTeacher', array('form'=>$form,'msg'=>'邀请不成功，用户已存在或已被邀请！'));
				exit();
			}else{
				$this->render('intiveTeacher', array('form'=>$form,'msg'=>'教师邀请成功！'));
				exit();
			}
		}
		$this->render('intiveTeacher', array('form'=>$form));
	}

	public function actionInviteStudent(){
		$model = new UserActive;
		$form = new CForm('application.modules.user.views.LibUser.inviteStudentForm', $model);
		if($form->submitted('resendBtn')){
			$cgrd = LibClass::model()->findByPk($_POST['UserActive']['class_id']);
			$stuinfo = array('schoolid'=>Yii::app()->params['currentSchoolID'],'stuinfo'=>array(array('姓名'=>$_POST['UserActive']['name'],'学号'=>$_POST['UserActive']['school_unique_id'],'班级ID'=>$_POST['UserActive']['class_id'],'年级'=>$cgrd->grade_info->grade_name)));
			//$res = LibUser::model()->addTeacherFromArray($stuinfo['stuinfo'],Yii::app()->params['currentSchoolID']);
			$res = Libuser::model()->addUserFromArray($stuinfo['stuinfo'],$stuinfo['schoolid']);
			if($res['success'] < 1){
				$this->render('intiveStudent', array('form'=>$form,'msg'=>'添加不成功，用户已存在或已被导入！'));
				exit();
			}else{
				$this->render('intiveStudent', array('form'=>$form,'msg'=>'学生添加成功！'));
				exit();
			}
		}
		$this->render('intiveTeacher', array('form'=>$form));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LibUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{	
		if(isset($_POST['ajax']) && $_POST['ajax']==='libuser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}