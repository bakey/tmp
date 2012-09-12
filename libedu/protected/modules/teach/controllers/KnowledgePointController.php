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
}
?>