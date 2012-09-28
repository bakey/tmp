<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理',
);
?>
<h1>
<?php
	echo(Yii::app()->user->real_name . ",");
	echo("这是你的课程: " ); 
?>
</h1>
<?php
$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
