<?php

class EditionController extends Controller
{
	const ITEM_LEVEL_TOP = 1;
	public function actionIndex()
	{
		$this->render('index');
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
		$model=new CourseEdition('search');
		$model->unsetAttributes();
		$this->render('admin' , array('model'=>$model , ));
	}
	public function actionView()
	{
		$dataProvider=new CActiveDataProvider('CourseEdition',array(
				'pagination'=>array('pageSize'=>15),
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
		$this->performAjaxValidation( $item_providor->getData() , 'item-form');
		$new_item = new Item;
		if(isset($_POST['Item']))
		{
			$new_item->edi_index   = $_POST['Item']['edi_index'];
			$new_item->content     = $_POST['Item']['content'];
			$new_item->edition     = $id;
			$new_item->level       = self::ITEM_LEVEL_TOP ; //这个页面的level都为1
			$new_item->create_time = date ("Y-m-d H:i:s", time() );
			
			if ( $new_item->save() )
			{
				$this->redirect( array('edition/update&id=' . $id ) );
			}
			else {
				throw new CHttpException( 500 , "保存教材到数据库错误");
			}
		}
		$this->render('update',array(
				'edition' => $edition ,
				'new_item' => $new_item,	
				'dataProvider' => $item_providor,			
		));
	}
	public function actionAjaxFillTree()
	{
		// accept only AJAX request (comment this when debugging)
		/*if (!Yii::app()->request->isAjaxRequest) {
			exit();
		}*/
		// parse the user input
		$parentId = "NULL";
		$levelCondition = "";
		if ( isset($_GET['root']) ) {
			if ( $_GET['root'] !== 'source' ){
				$parentId = (int) $_GET['root'];
				$levelCondition = " tbl_item.level > 1 ";
			}else if( isset($_GET['edition_id']) ) {
				$parentId = (int)$_GET['edition_id'];
				$levelCondition = " tbl_item.level <=> 1 "; 
			}
			else {
				exit();
			}
		}
		
		// read the data (this could be in a model)
		$children = Yii::app()->db->createCommand(
				"SELECT tbl_item.id, tbl_item.content AS text, tbl_item.id<=>tbl_item_item.parent AS hasChildren "
				."FROM tbl_item join tbl_item_item where tbl_item.edition <=> "
				. $parentId . " and "
				. $levelCondition
				. " group by tbl_item.id"
        )->queryAll();
		
		$treedata=array();
		foreach($children as $child){
			$options=array('href'=>'#','id'=>$child['id'],'class'=>'treenode');
			$nodeText = CHtml::openTag('a', $options);
			$nodeText.= $child['text'];
			$nodeText.= CHtml::closeTag('a')."\n";
			$child['text'] = $nodeText;
			$treedata[]=$child;
		}
		
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