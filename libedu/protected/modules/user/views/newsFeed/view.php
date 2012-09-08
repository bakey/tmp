<?php
$this->breadcrumbs=array(
	'News Feeds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NewsFeed', 'url'=>array('index')),
	array('label'=>'Create NewsFeed', 'url'=>array('create')),
	array('label'=>'Update NewsFeed', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewsFeed', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewsFeed', 'url'=>array('admin')),
);
?>

<h1>View NewsFeed #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sender.user_name',
		'type',
		'create_time',
		'resource_id',
		'content',
	),
)); ?>
