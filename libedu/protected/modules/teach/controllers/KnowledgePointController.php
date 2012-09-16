<?php

class KnowledgePointController extends Controller
{
	public function actionIndex()
	{
		//TODO : mock school id . from the parameter of school_id, to be change to get from the user model
		if ( isset( $_GET['school_id'] ) )
		{
			$school_id = (int) $_GET['school_id'];
		}
		else {
			throw new CHttpException( 400 , "Lack of the school id ");
		}
		
		/*
		 * 1: get school model   [done]
		 * 2: from school model get all the course belong to the school;
		 */
		$school = School::model()->findByPk( $school_id );
		if ( $school != null ){
			$courses = $school->course;						
		}else {
			throw new CHttpException( 500 , "No this school id : " . $school_id );
		}
		$list_course = CHtml::listData($courses, 'id', 'name');
		$list_grade = array();
		foreach( $courses as $course )
		{
			$grade = Grade::model()->findByPk( $course->grade )	;
			if ( $grade != null )
			{
				$list_grade[ $course->grade ] = $grade->grade_name ;
			}			
		}
		$kp_model = new KnowledgePoint;
		if ( isset($_POST['KnowledgePoint']) )
		{
			$kp_model->name = $_POST['KnowledgePoint']['name'];
			$kp_model->description = $_POST['KnowledgePoint']['description'];
			$kp_model->level = (int) $_POST['KnowledgePoint']['level'];
			$kp_model->course_id = (int) $_POST['KnowledgePoint']['course_id'];
			$kp_model->save();				
		}
		$dataProvider=new CActiveDataProvider('KnowledgePoint',array(
				'criteria'=>array(
						'condition'=>'course_id=1',
				),
				'pagination'=>array('pageSize'=>15),
		));
		$condition = null;
		$dataProvider = null;
		if ( isset( $_POST['course']) )
		{
			$condition .= "course_id=" . $_POST['course'];
			$dataProvider=new CActiveDataProvider('KnowledgePoint',array(
					'criteria'=>array(
							'condition'=>$condition ,
					),
					'pagination'=>array('pageSize'=>15),
			));	
			$this->renderPartial( '_form_showkp' , array('dataProvider' => $dataProvider));
		}
		else
		{
			$dataProvider=new CActiveDataProvider('KnowledgePoint',array(
					'pagination'=>array('pageSize'=>15),
			));
			$this->render('index' , array(
					'dataProvider'=>$dataProvider,
					'list_course'=>$list_course,
					'list_grade'=>$list_grade,
					'courses'=>$courses,
					'kp_model'=>$kp_model,
			));
		}	
	}	
	public function actionFilterKnowledgePoint()
	{
		echo("abckajkdfs");
		var_dump( $_POST );
		/*$data=Location::model()->findAll('parent_id=:parent_id',
				array(':parent_id'=>(int) $_POST['country_id']));
	
		$data=CHtml::listData($data,'id','name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
					array('value'=>$value),CHtml::encode($name),true);
		}*/
	}
	private function getKnowledgePointInfoFromExcelFile($fname = null){
		if($fname == null){
			return array();
		}
		$kpinfo = array();
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
			$currentSheet = $PHPExcel->getSheet(1);
				
			$ttlColumn = $currentSheet->getHighestColumn();
			$ttlRow = $currentSheet->getHighestRow();
				
			for($irow=1;$irow < $ttlRow; $irow++){
				for($icolumn=0;$icolumn<2;$icolumn++){
					if($currentSheet->getCellByColumnAndRow(1,$irow)->getValue() == ''){
						break 2;
					}
					echo( $currentSheet->getCellByColumnAndRow( $icolumn , $irow ) );
					/*$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(0,3)->getValue()] = $currentSheet->getCellByColumnAndRow(0,$irow)->getValue();
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(1,3)->getValue()] = $currentSheet->getCellByColumnAndRow(1,$irow)->getValue();
					$stuinfo[$irow-4][$currentSheet->getCellByColumnAndRow(3,3)->getValue()] = $currentSheet->getCellByColumnAndRow(3,$irow)->getValue();*/
				}
			}
			//$finalinfo['stuinfo'] = $stuinfo;
		}else{
			echo '无法读取文件！';
		}
		return $finalinfo;
	}
	public function actionTest()
	{
		$this->getKnowledgePointInfoFromExcelFile( '015C1200.xlsx' );
	}
	
	public function actionLoadKnowledgePoint()
	{
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		$kpdata = $this->getKnowledgePointInfoFromExcelFile( $fname );
		
	}
	public function actionImportKnowledgePoint()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$folder='./bin_data/temp_upload/';
		$allowedExtensions = array("xls","xlsx");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $return;// it's array		
	}
}
?>