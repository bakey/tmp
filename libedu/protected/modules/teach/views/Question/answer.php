<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h1>回答问题</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$cq,
	'attributes'=>array(
		'id',
		'owner',
		'item',
		array('type'=>'html','name'=>'details'),
		'create_time',
		'view_count',
	),
)); ?>


<?php echo $this->renderPartial('_answer', array('model'=>$model,'mycourse'=>$mycourse,'qid'=>$qid,'cq'=>$cq,'kp'=>$kp,'skp'=>$skp)); ?>