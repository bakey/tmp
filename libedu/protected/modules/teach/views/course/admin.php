<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'Course'=>array('/teach/course'),
	'Admin',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<?php
$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
