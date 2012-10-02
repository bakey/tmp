<?php
$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'浏览测验记录', 'url'=>array('index')),
	array('label'=>'新建测试', 'url'=>array('create')),
	//array('label'=>'Delete Task', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Task', 'url'=>array('admin')),
	//array('label'=>'Add Topics','url'=>array('add','id'=>$model->id)),
);
?>

<h1>测验情况 #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'striped',
	'attributes'=>array(
		'id',
		'name',
		'create_time',
		'update_time',
		'last_time',
		'description',
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
