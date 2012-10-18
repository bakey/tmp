<?php
Yii::app()->getClientScript()->scriptMap=array(
	'jquery.js'=>false,
);
?>

<h1>测验情况 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
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
