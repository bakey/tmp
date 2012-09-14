<?php
/* @var $this CoursePostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Course Posts',
);

$this->menu=array(
	array('label'=>'Create CoursePost', 'url'=>array('create')),
	array('label'=>'Manage CoursePost', 'url'=>array('admin')),
);
?>

<h1><?php 
echo(Yii::app()->user->real_name . "你好 , 你发布的课程如下:");
 ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
