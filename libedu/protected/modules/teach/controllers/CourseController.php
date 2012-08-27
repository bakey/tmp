<?php
class CourseController extends Controller
{
	public function actionIndex()
	{
		//$this->render('index');
		if ( isset($_GET['id']) )
		{
			$course_id = $_GET['id'];
			$course = Course::model()->findByPk( $course_id );
			//$edition = $course->edition;
			var_dump( $course->edition );
			//echo($edition->name);
			exit();
		}
		
	}
}
?>