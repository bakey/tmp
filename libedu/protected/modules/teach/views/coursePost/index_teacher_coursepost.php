<?php
/* @var $this CoursePostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'课程管理'=>array('course/admin'),
	'课程资料'=>array('course/update&course_id='.$course_id),
	'课程浏览',
);

$this->menu=array(
	array('label'=>'新建课程资料', 'url'=>array('create&item_id='.$item_id.'&course_id='.$course_id)),
);
?>

<h1><?php 
$msg = sprintf("%s , 你好，你在[%s]下发布的课程如下" , Yii::app()->user->real_name , $item_model->content );
echo $msg;
 ?></h1>
 
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
	'viewData'     => array('course_id'=>$course_id),
)); ?>

