<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'Course'=>array('/teach/course'),
	'Admin',
);
?>
<?php
echo(Yii::app()->user->real_name . ",");
echo("这是你的课程: " ); 
?>
<?php
$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
