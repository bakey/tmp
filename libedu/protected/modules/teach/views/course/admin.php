<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理',
);
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<h1>
<?php
	echo(Yii::app()->user->real_name . ",");
	echo("这是你的课程: " ); 
?>
</h1>
<a href="<?php
	echo ("index.php?r=teach/course/update&course_id=" . $course_data[0]->id ); 
?>">
<button class="sea glyph tag"  />
</a>
<span>
高一数学
</span>
</button>
<?php
//$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
