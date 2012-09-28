<?php
/* @var $this LibClassController */
/* @var $model LibClass */
/*
$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'学生管理',
);
*/
$this->menu=array(
	array('label'=>'新建班级', 'url'=>array('create')),
);
?>

<h1>班级管理</h1>

<div class="well">
<?php $this->widget('bootstrap.widgets.TbListView', array(
	'id'=>'lib-class-grid',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_class',
)); ?>
</div>
