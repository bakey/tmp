<?php

class LibUserController extends Controller
{
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

	public function actionNotActived(){
		$this->render('noactive',array('uemail'=>Yii::app()->User->uemail));
	}

	public function actionRegister(){
		$model=new LibUser;

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
		//to do
		var_dump($ua);
		die('a');
		$dataProvider=new CArrayDataProvider($stuinfo['stuinfo'], array(
		    'id'=>'loadeduser',
		    'keyField'=>'序号',
		    'sort'=>array(
		    	
		        'attributes'=>array(
		             '学号', '班级', '姓名', '班级ID'
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>15,
		    ),
		));
		//$this->renderPartial('_uploadedStudentInfo', array('dataProvider'=>$dataProvider,'schoolname'=>$stuinfo['schoolname'],'schoolid'=>$stuinfo['schoolid']), false, true);
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