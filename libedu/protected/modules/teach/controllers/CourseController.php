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
			if ( $course != null )
			{
				$items = $course->edition->items;
				$this->render( 'index' , array('item'=>$items , ) );
			}
			else{
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		
	}
}
?>