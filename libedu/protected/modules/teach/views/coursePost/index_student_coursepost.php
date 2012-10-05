<?php
/* @var $this CoursePostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'课程管理'=>array('course/admin'),
	'课程资料',
);

?>

<h1><?php 
echo(Yii::app()->user->real_name . "你好 , 你学习的课程如下:");
 ?></h1>
<div class="well">
<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'viewData' => array('course_id'=>$course_id),
)); ?>
</div>
