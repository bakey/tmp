<?php
/* @var $this LibClassApplyController */
/* @var $model LibClassApply */

$this->breadcrumbs=array(
	'Lib Class Applies'=>array('index'),
	$model->applicant,
);

$this->menu=array(
	array('label'=>'List LibClassApply', 'url'=>array('index')),
	array('label'=>'Create LibClassApply', 'url'=>array('create')),
	array('label'=>'Update LibClassApply', 'url'=>array('update', 'id'=>$model->applicant)),
	array('label'=>'Delete LibClassApply', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->applicant),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibClassApply', 'url'=>array('admin')),
);
?>

<h1>View LibClassApply #<?php echo $model->applicant; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'applicant',
		'approver',
		'class_id',
		'statement',
	),
)); ?>
