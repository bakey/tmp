<<<<<<< HEAD
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
=======
<<<<<<< HEAD
<?php
class CourseController extends Controller
{
	public function actionIndex()
	{
		//$this->viewPath='main';
		$this->render('index');
	}
}
=======
<?php
class CourseController extends Controller
{
	public function actionIndex()
	{
		//$this->viewPath='main';
		$this->render('index');
	}
}
>>>>>>> 597c27d0893309aa460e3cf020ccb55caba79df1
>>>>>>> 184ebc00c1a417fa606cd2c810f21e57827d03e4
?>