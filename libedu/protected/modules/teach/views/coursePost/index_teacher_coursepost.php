<?php
/* @var $this CoursePostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'课程管理'=>array('course/admin'),
	'课程资料',
);

$this->menu=array(
	array('label'=>'新建课程资料', 'url'=>array('create&item_id='.$item_id)),
	array('label'=>'管理课程', 'url'=>array('admin')),
);
?>

<h1><?php 
echo(Yii::app()->user->real_name . "你好 , 你发布的课程如下:");
 ?></h1>
<div class="well" >
<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
	'viewData'     => array('course_id'=>$course_id),
)); ?>
</div>
