<?php
$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Task', 'url'=>array('index')),
	array('label'=>'Create Task', 'url'=>array('create')),
	array('label'=>'Update Task', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Task', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Task', 'url'=>array('admin')),
	array('label'=>'Add Topics','url'=>array('add','id'=>$model->id)),
	array('label'=>'Add Examinees','url'=>array('addExaminee','id'=>$model->id)),
);
?>

<h1>View Task #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'striped',
	'attributes'=>array(
		'id',
		'item',
		'name',
		'create_time',
		'update_time',
		'last_time',
		'author',
		'description',
		'status',
	),
)); ?>
<?php
 if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) {
//只有老师才展示试卷分发情况
		$this->renderPartial('publish_task' , array(
							'task_record_model' => $task_record_model,
							'new_record'=>1,
							)
	 	);
	} 
?>
