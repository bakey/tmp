<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs=array(
	'Profiles'=>array('index'),
	$model->uid,
);

?>

<h1>View Profile #<?php echo $model->uid; ?></h1>

<<<<<<< HEAD
<?php
$avatarCode = ''; 
if($model->avatar != 'default_avatar.jpg'){
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/bin_data/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}else{
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}
$this->widget('zii.widgets.CDetailView', array(
=======
<?php $this->widget('zii.widgets.CDetailView', array(
>>>>>>> 533f54baa83bcadd115374ca1cf6cd6904febf3c
	'data'=>$model,
	'attributes'=>array(
		'uid',
		array(
			'label'=>'用户头像',
			'type'=>'raw',
<<<<<<< HEAD
			'value'=>$avatarCode,
=======
			'value'=>html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64))),
>>>>>>> 533f54baa83bcadd115374ca1cf6cd6904febf3c
		),
		'real_name',
		'user_info.user_name',
		'user_info.email',
		'user_info.mobile',
		'description',
	),
)); ?>
