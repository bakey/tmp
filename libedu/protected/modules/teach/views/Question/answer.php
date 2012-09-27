<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h3>回答问题</h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$cq,
	'attributes'=>array(
		array('name'=>'owner','value'=>$cq->owner_info->user_profile->real_name),
		array('name'=>'item','value'=>$cq->item_info->content),
		array('type'=>'html','name'=>'details'),
		'create_time',
	),
)); ?>


<?php echo $this->renderPartial('_answer', array('model'=>$model,'mycourse'=>$mycourse,'qid'=>$qid,'cq'=>$cq,'kp'=>$kp,'skp'=>$skp)); ?>