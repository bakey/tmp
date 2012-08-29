<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs=array(
	'Profiles'=>array('index'),
	$model->uid,
);

?>

<h1>View Profile #<?php echo $model->uid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'uid',
		array(
			'label'=>'用户头像',
			'type'=>'raw',
			'value'=>html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64))),
		),
		'real_name',
		'user_info.user_name',
		'user_info.email',
		'user_info.mobile',
		'description',
	),
)); ?>
