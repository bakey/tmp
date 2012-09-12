<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'Course Posts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CoursePost', 'url'=>array('index')),
	array('label'=>'Create CoursePost', 'url'=>array('create')),
	array('label'=>'Update CoursePost', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoursePost', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoursePost', 'url'=>array('admin')),
);
?>

<h1>View CoursePost #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'post',
		'author',
		'item_id',
		'status',
		'create_time',
		'update_time',
	),
)); ?>
