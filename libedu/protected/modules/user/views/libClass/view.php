<?php
/* @var $this LibClassController */
/* @var $model LibClass */

$this->breadcrumbs=array(
	'Lib Classes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibClass', 'url'=>array('index')),
	array('label'=>'Create LibClass', 'url'=>array('create')),
	array('label'=>'Update LibClass', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibClass', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibClass', 'url'=>array('admin')),
);
?>

<h1>View LibClass #<?php echo $model->id; ?></h1>
<p><a href="<?php echo Yii::app()->createUrl('/user/libclass/update',array('id'=>$model->id)); ?>">编辑</a></p>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'school_id',
		'name',
		'grade',
		'classhead_id',
		'description',
	),
)); ?>
