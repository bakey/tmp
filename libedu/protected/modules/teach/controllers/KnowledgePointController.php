<?php

class KnowledgePointController extends Controller
{
	private $cur_course;
	public function actionIndex()
	{
		$school_id = Yii::app()->params['currentSchoolID'];
		
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
	public function actionImportKP()
	{
		if ( isset($_GET['course_id']) ){
			$this->cur_course = $_GET['course_id'];
		}else {
			throw new CHttpException( 500 , "invalid url , no course id ");
		}
		$this->render('import_kp',
				array('course'=>$this->cur_course,) );
	}
	public function actionFilterKnowledgePoint()
	{
		var_dump( $_POST );
	}
	/*
	 * 检查知识点excel文件是否已经到文件尾
	 * @return null 如果已到文件尾。如果还没到，返回array，标记下一行数据的cell坐标。array('row','col')
	 */
	private function checkEOF( $sheet , $row , $col , $level )
	{
		//echo("checing...row = " . $row . ", col = " . $col . "<br>");
		if ( $sheet->getCellByColumnAndRow( $col , $row )->getValue() == '' )
		{
			//如果当前cell没数据，那么先往右推一列看看
			if ( $sheet->getCellByColumnAndRow( $col+1 , $row )->getValue() != '' ) {
				return array( 'row'=>$row , 'col'=>$col+1 , 'level'=>$level+1 );				
			}
			/*如果本行本列没有数据，意味着同个level的知识点kp没有了。
			 * 那么我们往下一行的第一列看看，是否重新开始了一个最高层的知识点kp,如果还没有，那么文件结束。
			 */
			if ( $sheet->getCellByColumnAndRow( 0 , $row )->getValue() == '' ) {
				return null ;
			}
			else {
				return array( 'row'=>$row, 'col'=>0 , 'level'=>1 );
			}
		}
		else
		{
			//echo("return my level = " . $level . "<br>");
			return array( 'row'=>$row , 'col'=>$col , 'level'=>$level );
		}
	}
	private function getKnowledgePointInfoFromExcelFile($fname = null){
		if($fname == null){
			return array();
		}
	
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
			//默认每个模板都放在sheet 0
			$currentSheet = $PHPExcel->getSheet( 0 );
				
			$topColumn = $currentSheet->getHighestColumn();
			$topRow = $currentSheet->getHighestRow();
			
			$currentRow = 1;
			$currentCol = 0;
			$kp = array();
			$level = 1;
			$id = 0;
			
			while ( true )
			{		
				$nextNode = $this->checkEOF( $currentSheet , $currentRow , $currentCol , $level );
				if ( $nextNode == null ) {
					break;
				}		
				$currentRow = $nextNode['row'];
				$currentCol = $nextNode['col'];
				$cur_node = array(
						'edi_index' => $currentSheet->getCellByColumnAndRow( $currentCol , $currentRow )->getValue(),
						'name' => $currentSheet->getCellByColumnAndRow( $currentCol+1 , $currentRow )->getValue(),
						'description' => $currentSheet->getCellByColumnAndRow( $currentCol+2 , $currentRow )->getValue(),
						);
				if ( $nextNode['level'] == 1 )
				{
					$cur_node['parent'] = -1 ;
				}
				else if ( $nextNode['level'] == $level + 1 )
				{
					$cur_node['parent'] = count( $kp ) - 1;
				}
				else {
					$cur_node['parent'] = $kp[ count($kp)-1 ]['parent'];
				}
				$level = $nextNode['level'];
				$cur_node['level'] = $level;
				$cur_node['id'] = $id ++ ;
				//echo("current level = " . $level . "<br>" );
				$kp[] = $cur_node;
				++ $currentRow;				
			}
		}
		return $kp;
	}
	public function actionTest()
	{
		$kpdata = $this->getKnowledgePointInfoFromExcelFile( '8.xls' );
		$succ = 0;
		$kp_map = null;
		$index = 0;
		foreach( $kpdata as $kp )
		{
			$kp_model = new KnowledgePoint;
			$kp_model->course_id = 0;
			$kp_model->name = $kp['name'];
			if ( $kp['description'] == null ){
				$kp_model->description = $kp_model->name;
			}else {
				$kp_model->description = $kp['description'];
			}
			$kp_model->level = $kp['level'];
			//$str = sprintf("id=%d , name = %s , parent = %d , level = %d<br>" , $kp['id'] , $kp['name'] , $kp['parent'] , $kp['level']);
			//echo( $str );
			//最顶层的知识点，直接save
			if ( $kp_model->level == 1 ) {
				if ( $kp_model->save() ){
					//将当前的id映射为db中的id
					$kp_map[ $kp['id'] ]= $kp_model->id;
					++ $succ;
				}
			}
			else if ( $kp_model->save() ) {
				++ $succ;
				$kp_map[ $kp['id'] ] = $kp_model->id;
			}
			if ( $kp['parent'] != -1 ) {
				$kp['parent'] = $kp_map[ $kp['parent'] ] ;
			}			
			$kpdata[$index ]['id'] = $kp_model->id;
			$kpdata[$index ++]['parent'] = $kp['parent'];
		}
		$dataProvider=new CArrayDataProvider( $kpdata , array(
				'id'=>'loadedkp',
				'pagination'=>array(
						'pageSize'=>15,
				),
		));
		
		$this->render('_show_new_import' , array('dataProvider'=>$dataProvider));
	}
	public function actionWriteKnowledgePointData()
	{
		$cid = -1;
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		if ( isset($_GET['course_id']) ) {
			$cid = (int) $_GET['course_id'];
		}
		$kpdata = $this->getKnowledgePointInfoFromExcelFile( $fname );
		$succ = 0;
		$kp_map = null;
		$index = 0;
		foreach( $kpdata as $kp )
		{
			$kp_model = new KnowledgePoint;
			$kp_model->course_id = $cid;
			$kp_model->name = $kp['name'];
			if ( $kp['description'] == null ){
				$kp_model->description = $kp_model->name;
			}else {
				$kp_model->description = $kp['description'];
			}
			$kp_model->level = $kp['level'];
		
			//最顶层的知识点，直接save
			if ( $kp_model->level == 1 ) {
				if ( $kp_model->save() ){
				//	将当前的id映射为db中的id
					$kp_map[ $kp['id'] ]= $kp_model->id;
					++ $succ;
				}
			}
			else if ( $kp_model->save() ) {
				++ $succ;
				$kp_map[ $kp['id'] ] = $kp_model->id;
			}
			if ( $kp['parent'] != -1 ) {
				$kp['parent'] = $kp_map[ $kp['parent'] ] ;
			}
			$kpdata[$index ]['id'] = $kp_model->id;
			$kpdata[$index ++]['parent'] = $kp['parent'];
		}
		foreach( $kpdata as $kp )
		{
			$kp_level_model = new KpLevel;
			if ( $kp['parent'] != -1 )
			{
				$kp_level_model->parent = $kp['parent'];
				$kp_level_model->child = $kp['id'];
				if ( !$kp_level_model->save() ){
					echo("save kp level model failed ");					
				}
				/*$str = sprintf("parent = %d , child = %d<br>" , $kp['parent'],
						$kp['id'] );
				echo $str;*/
			}			
		}
		echo '<h4>知识点列表导入结果</h4><ul><li>成功导入 <strong>' . $succ . '</strong> 条记录</li>';
		
	}
	
	public function actionLoadKnowledgePoint()
	{
		$cid = -1;
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		if ( isset($_GET['course_id']) ) {
			$cid = (int) $_GET['course_id'];
		}
		$kpdata = $this->getKnowledgePointInfoFromExcelFile( $fname );
		
		$dataProvider=new CArrayDataProvider( $kpdata , array(
				'id'=>'loadedkp',
				'pagination'=>array(
						'pageSize'=>15,
				),
		));
		
		$this->renderPartial('_show_new_import' , array('dataProvider'=>$dataProvider));		
	}
	public function actionDoImportKnowledgePoint()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$folder = './'.Yii::app()->params['uploadFolder'].'/temp_upload/';
		$allowedExtensions = array("xls","xlsx");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $return;// it's array		
	}
}
?>