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
<button class="sea glyph tag" onclick="javascript:window.location.href='index.php?r=teach/course/update&course_id=2';">
<span>
高一数学
</span>
</button>
<?php
$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
