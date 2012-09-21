<?php

class EditionController extends Controller
{
	const ITEM_LEVEL_TOP = 1;
	const TBL_ITEM = "tbl_item";
	const TBL_ITEM_LEVEL = "tbl_item_item";
	public function actionIndex()
	{
		$this->render('index');
	}
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
						'actions'=>array('index','view','importedition'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('admin','test','update','loadedition','doimportedition','writeedition','ajaxfilltree','add'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	public function actionAdd()
	{
		$model = new CourseEdition;
		$this->performAjaxValidation($model , 'edition-form');
		if(isset($_POST['CourseEdition']))
		{
			//var_dump( $_POST['CourseEdition'] );
			$model->name = $_POST['CourseEdition']['name'];
			$model->description = $_POST['CourseEdition']['description'];
			if ( $model->save() )
			{
				$this->redirect( array('edition/view') );
			}
			else {
				//echo("保存教材到数据库错误" . "<br>");
				throw new CHttpException( 500 , "保存教材到数据库错误");
			}
		}
		$this->render('add' , array('model'=>$model));		
	}
	public function actionAdmin()
	{
		$course_edition_model=new CourseEdition('search');
		$course_edition_model->unsetAttributes();
		
		$subjects = Subject::model()->findAll();
		$grades = Grade::model()->findAll();
		$subject_list = CHtml::listData($subjects, 'id', 'name');
		$grade_list = CHtml::listData($grades , 'grade_index' , 'grade_name' );
		
		if ( isset( $_POST['subject']) )
		{
			//ajax filter edition
			$subject_id = $_POST['subject'];
			$grade_id = $_POST['grade'];
			
			
			
			$condition = "subject=" . $subject_id . " and grade=" . $grade_id; 
			$dataProvider=new CActiveDataProvider('CourseEdition',array(
					'criteria'=>array(
							'condition'=>$condition ,
					),
					'pagination'=>array('pageSize'=>15),
			));
			$cnt = count($dataProvider->getData());
			$str = @sprintf("subject=%d , grade = %d , count = %d" ,
					 $subject_id,$grade_id , $cnt );
			Yii::log( $str , 'debug' );
			$this->renderPartial( '_form_show_edition' , 
						array('dataProvider' => $dataProvider,
							  // 'model'=>$course_edition_model,
								));
			
		}else {
			$dataProvider=new CActiveDataProvider('CourseEdition',array(
					'pagination'=>array('pageSize'=>15),
			));
			$this->render('admin' , array(
				'model'=>$course_edition_model ,
				'dataProvider'=>$dataProvider, 
				'subject_list' => $subject_list,
				'grade_list' => $grade_list,
				));
		}
	}
	public function actionImportEdition()
	{
		$this->render('import_edition');
	}
	public function actionView($id)
	{
		$dataProvider=new CActiveDataProvider('CourseEdition',array(
				'pagination'=>array('pageSize'=>15),
				'criteria'=>array(
						'condition'=>'id=:id',
						),
				'params'=>array(
						':id'=>$id,
						),
		));
		$this->render('view',array(
				'dataProvider'=>$dataProvider,
		));	
	}
	public function actionUpdate($id)
	{
		$edition = $this->loadModel($id);
		
		$critieria = new CDbCriteria;
		$critieria->condition = 'edition=:edition';
		$critieria->params = array(
				':edition' => $id );
		$item_providor = new CActiveDataProvider('Item',array(
				'pagination'=>array('pageSize'=>15),
				'criteria' => $critieria , 
		));
		
		if ( $edition == null )
		{
			throw new CHttpException( 500 , "抱歉，数据库查询错误" );
		}
		$this->performAjaxValidation( $item_providor->getData() , 'Item');
		$new_item = new Item;
		$form = new CForm('application.modules.teach.views.edition.addItemForm' , $new_item );
		if(isset($_POST['Item']) )
		{
			$new_item->attributes = $_POST['Item'];
			if ( $new_item->validate() )
			{
				$new_item->edi_index   = (int) $_POST['Item']['edi_index'];
				$new_item->content     = $_POST['Item']['content'];
				$new_item->edition     = $id;
				$new_item->level       = (int) $_POST['Item']['level']; //self::ITEM_LEVEL_TOP ; //这个页面的level都为1
				$new_item->create_time = date ("Y-m-d H:i:s", time() );
				
				if ( $new_item->save() )
				{
					if ( $new_item->level > 1 )
					{
						$multi_item = new ItemItem;
						$multi_item->parent = $_POST['Item']['parent'];
						$multi_item->child = $new_item->id;
						$multi_item->save();
					}
					$this->redirect( array('edition/update&id=' . $id ) );
				}
				else {
					throw new CHttpException( 500 , "保存教材到数据库错误");
				}
			}
			else
			{
				throw new CHttpException( 500 , "章节数据有误");
			}
		}
		$this->render('update',array(
				'edition'      => $edition ,
				'new_item'     => $new_item,	
				'dataProvider' => $item_providor,
				'form'	 	   => $form,		
		));
	}
	public function actionDoImportEdition()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$uid = Yii::app()->user->id;
		$folder = './'.Yii::app()->params['uploadFolder'].'/temp_upload/';
		if ( !@is_dir($folder) ) {
			@mkdir( $folder );
		}
		$allowedExtensions = array("xls","xlsx");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $return;// it's array		
	}
	/*
	 * 检查知识点excel文件是否已经到文件尾
	* @return null 如果已到文件尾。如果还没到，返回array，标记下一行数据的cell坐标。array('row','col')
	*/
	private function checkEOF( $sheet , $row , $col , $level )
	{
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
			return array( 'row'=>$row , 'col'=>$col , 'level'=>$level );
		}
	}
	private function getPHPExcelInstance( $fname )
	{
		$filePath = './'.Yii::app()->params['uploadFolder'].'/temp_upload/' . $fname;
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
					return null ;
				}
			}
		}
		
		$PHPExcel = $PHPReader->load($filePath);
		return $PHPExcel;		
	}
	private function getEditionFromExcelFile( $fname )
	{
		if($fname == null){
			return array();
		}
		$uid = Yii::app()->user->id;		
	
		$PHPExcel = $this->getPHPExcelInstance( $fname );
		if ( null == $PHPExcel ){
			throw new CHttpException( 500 , "get php excel instance failed");
		}
		
			//默认每个模板都放在sheet 0
		$sheet = $PHPExcel->getSheet( 0 );
		
		$topColumn = $sheet->getHighestColumn();
		$topRow    =  $sheet->getHighestRow();
		$currentRow = 1;
		$currentCol = 0;
			
		$edition_name = $sheet->getCellByColumnAndRow( $currentCol , $currentRow )->getValue();
		$description = $sheet->getCellByColumnAndRow( $currentCol+1 , $currentRow )->getValue();
		if ( $description == '' ) {
			$description = $edition_name;
		}
		$publisher = $sheet->getCellByColumnAndRow( $currentCol+2 , $currentRow)->getValue();
		
		$edition_info = array(
				'name'=>$edition_name,
				'description'=>$description,
				'uploader'=>$uid,
				'publisher'=>$publisher,
				);
		
		$return_data = array();
		$edition_item = array();
		$ei_index = 0;
		$level = 1;
		$id = 0;
		++ $currentRow;
				
		while ( true )
		{
			$nextNode = $this->checkEOF( $sheet , $currentRow , $currentCol , $level );
			if ( $nextNode == null ) {
				break;
			}
			$currentRow = $nextNode['row'];
			$currentCol = $nextNode['col'];
			$cur_node = array(
					'edi_index' => $sheet->getCellByColumnAndRow( $currentCol , $currentRow )->getValue(),
					//'name' => $currentSheet->getCellByColumnAndRow( $currentCol+1 , $currentRow )->getValue(),
					'content' => $sheet->getCellByColumnAndRow( $currentCol+1 , $currentRow )->getValue(),
			);
			if ( $cur_node['content'] == '' ) {
				$cur_node['content'] = '默认内容';
			} 
			$ei_index = count( $edition_item ) - 1 ;
			if ( $nextNode['level'] == 1 )
			{
				$cur_node['parent'] = -1 ;
			}
			else if ( $nextNode['level'] == $level + 1 )
			{
				$cur_node['parent'] = $ei_index ;
			}
			else {
				$cur_node['parent'] = $edition_item[ $ei_index ]['parent'];
			}
			$level = $nextNode['level'];
			$cur_node['level'] = $level;
			$cur_node['id'] = $id ++ ;
			$edition_item[] = $cur_node;
			++ $ei_index;
			++ $currentRow;
		}
		$return_data['edition_item'] = $edition_item;
		$return_data['edition_info'] = $edition_info;
		return $return_data ;		
	}
	public function actionTest()
	{
		$fname = 'gg.xls';
		$edition_data = $this->getEditionFromExcelFile( $fname );
		
		$edition_model = $this->saveEditionData( $edition_data['edition_info'] );
		$edition_id = $edition_model->id;
		$succ = 0;
		$edi_map = null;
		$index = 0;
		$items = $edition_data['edition_item'];
		foreach( $items as $ed )
		{
			$item_model = new Item;
			$item_model->edition = $edition_id ;
			$item_model->edi_index = $ed['edi_index'];
			$item_model->content = $ed['content'];
			$item_model->level = $ed['level'];
			$item_model->create_time = date("Y-m-d H:i:s", time() );
				
			//最顶层的知识点，直接save
			if ( $item_model->level == 1 ) {
				if ( $item_model->save() ){
					//	将当前的id映射为db中的id
					$edi_map[ $ed['id'] ]= $item_model->id;
					++ $succ;
				}
			}
			else if ( $item_model->save() ) {
				++ $succ;
				$edi_map[ $ed['id'] ]= $item_model->id;
			}
			if ( $ed['parent'] != -1 ) {
				$ed['parent'] = $edi_map[ $ed['parent'] ] ;
			}
			$items[$index ]['id'] = $item_model->id;
			$items[$index ++]['parent'] = $ed['parent'];
		}
		
		foreach( $items as $ed )
		{
			$item_item_model = new ItemItem ;
			if ( $ed['parent'] != -1 )
			{
				$item_item_model->parent = $ed['parent'];
				$item_item_model->child = $ed['id'];
				if ( !$item_item_model->save() ){
					echo("save item_item model failed ");
				}
				$str = sprintf("parent = %d , child = %d<br>" , $ed['parent'],
						$ed['id'] );
				echo $str;
			}
		}	
	}
	private function saveEditionData( $edi_info )
	{
		$edition_model = new CourseEdition;
		$edition_model->name = $edi_info['name'];
		$edition_model->description = $edi_info['description'];
		$edition_model->uploader = $edi_info['uploader'];
		$edition_model->publisher = $edi_info['publisher'];
		$edition_model->save();		
		return $edition_model;
	}
	
	public function actionWriteEdition()
	{
		if(!$_REQUEST['fname']){
			$fname = null;
		}else{
			$fname = $_REQUEST['fname'];
		}
		
		$edition_data = $this->getEditionFromExcelFile( $fname );
		
		$edition_model = $this->saveEditionData( $edition_data['edition_info'] );
		$edition_id = $edition_model->id;
		$succ = 0;
		$edi_map = null;
		$index = 0;
		$items = $edition_data['edition_item'];
		foreach( $items as $ed )
		{
			$item_model = new Item;
			$item_model->edition = $edition_id ;
			$item_model->edi_index = $ed['edi_index'];
			$item_model->content = $ed['content'];
			$item_model->level = $ed['level'];
			$item_model->create_time = date("Y-m-d H:i:s", time() );
				
			//最顶层的知识点，直接save
			if ( $item_model->level == 1 ) {
				if ( $item_model->save() ){
					//	将当前的id映射为db中的id
					$edi_map[ $ed['id'] ]= $item_model->id;
					++ $succ;
				}
			}
			else if ( $item_model->save() ) {
				++ $succ;
				$edi_map[ $ed['id'] ]= $item_model->id;
			}
			if ( $ed['parent'] != -1 ) {
				$ed['parent'] = $edi_map[ $ed['parent'] ] ;
			}
			$items[$index ]['id'] = $item_model->id;
			$items[$index ++]['parent'] = $ed['parent'];
		}
		
		foreach( $items as $ed )
		{
			$item_item_model = new ItemItem ;
			if ( $ed['parent'] != -1 )
			{
				$item_item_model->parent = $ed['parent'];
				$item_item_model->child = $ed['id'];
				if ( !$item_item_model->save() ){
					echo("save item_item model failed ");
				}
				/*$str = sprintf("parent = %d , child = %d<br>" , $ed['parent'],
						$ed['id'] );
				echo $str;*/
			}
		}	
		echo '<h4>教材列表导入结果</h4><ul><li>成功导入 <strong>' . $succ . '</strong> 条记录</li>';
	}
	public function actionLoadEdition()
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
		$edition = $this->getEditionFromExcelFile( $fname );
		
		$dataProvider=new CArrayDataProvider( $edition ['edition_item'], array(
				'id'=>'loadededition',
				'pagination'=>array(
						'pageSize'=>15,
				),
		));
		
		$this->renderPartial('_show_new_edition' , array(
				'dataProvider'=>$dataProvider));
	}
	public function actionAjaxFillTree()
	{
		// accept only AJAX request (comment this when debugging)
		/*if (!Yii::app()->request->isAjaxRequest) {
			exit();
		}*/
		// parse the user input
		$parentId = null ;
		$editionId = null ;
		$levelCondition = "";
		
		if ( isset($_GET['edition_id']) ) {
			$editionId = $_GET['edition_id'];
		}
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				//深层查询,获取父亲id
				$parentId = (int) $_GET['root'];
				$levelCondition = " level > 1 " ;
			}else if( isset($_GET['edition_id']) ) {
				//第一层查询
				//$parentId = (int)$_GET['edition_id'];
				$levelCondition = " level <=> 1 "; 
			}
			else {
				exit();
			}
		}
		$condition = "edition=:edition ";
		if ( $parentId != null ) {
			$condition .= "and level > 1 ";
		}
		else {
			$condition .= "and level = 1 ";
		}
		$children = array();
		$items = Item::model()->findAll(
					$condition,
					 array(':edition'=>$editionId)
				);
		foreach( $items as $it )
		{
			$info = array() ;
			$parent = $it->level_parent ;
			if ( count($it->level_child) > 0 ) {
				$info['hasChildren'] = 1;
			}else {
				$info['hasChildren'] = 0;
			}
			$info['text'] = $it->content;	
			$info['id']	= $it->id;	
			if ( $parentId == null ) {
				$children[] = $info;
			}else if ( count($parent) > 0 && $parent[0]->id == $parentId ) {
				$children[] = $info;
			}
		}
		
		/*
		 * 我们期望或得到类似" id content hasChildren"排列的数据，通过json方式返回给ajax调用，
		 * 前端接收到后根据这个信息渲染出树状结构。
		 */
		//$sql_cmd = sprintf("SELECT %s.id, %s.content AS text, max(%s.id<=>%s.parent) AS hasChildren FROM %s join %s where %s.edition <=> %s ",
			//	self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , self::TBL_ITEM_LEVEL , self::TBL_ITEM , $editionId );
	
	
		
		
		// read the data (this could be in a model)
		//$children = Yii::app()->db->createCommand( $sql_cmd )->queryAll();
		
		$treedata=array();
		foreach($children as $child){
			$options=array(/*'href'=>'#',*/'id'=>$child['id'],'class'=>'treenode');
		//	$nodeText = CHtml::openTag('a', $options);
			$nodeText = $child['text'];
			//$nodeText.= CHtml::closeTag('a')."\n";
			$child['text'] = $nodeText;
			$treedata[]=$child;
		}
		//var_dump( $treedata );
		//exit();
		
		echo str_replace(
			'"hasChildren":"0"',
			'"hasChildren":false',
			CTreeView::saveDataAsJson($treedata)
		 	//CTreeView::saveDataAsJson($children)
		);
	}
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
	
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	protected function performAjaxValidation($model , $whichForm)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']=== $whichForm /*'edition-form'*/)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function loadModel($id)
	{
		$model=CourseEdition::model()->findByPk($id);
		if($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	/*public function loadItemsByEdition($edition)
	{
		$critieria = new CDbCriteria;
		$critieria->condition = 'edition=:edition';
		$critieria->params = array(
				':edition' => $edition->id );
		return Item::model()->findAll( $critieria );
	}*/

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
?>