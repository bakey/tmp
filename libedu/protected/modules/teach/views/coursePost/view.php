<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'课程管理'=>array('course/admin'),
	$model->id,
);
/*
$this->menu=array(
	array('label'=>'List CoursePost', 'url'=>array('index')),
	array('label'=>'Create CoursePost', 'url'=>array('create')),
	array('label'=>'Update CoursePost', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoursePost', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoursePost', 'url'=>array('admin')),
);
*/
?>

<h1>View CoursePost #<?php echo $model->id; ?></h1>

<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'post:html',
		'status',
	),
));
echo CHtml::button('重新编辑' , array(
		'onClick'=>"window.location.href='$reedit_url'",
) );
if ( $model->status == Yii::app()->params['course_post_status_draft'] ) {
	echo CHtml::button('发布课程资料', array( 
		'onClick'=>"window.location.href='$draft_to_publish_url'", 
	));
}
?>
