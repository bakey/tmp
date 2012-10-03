<?php
/* @var $this ProfileController */
/* @var $model Profile */

?>

<h1><?php echo $model->real_name; ?>的账号</h1>
<p></p>
<?php
$avatarCode = ''; 
if($model->avatar != 'default_avatar.jpg'){
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}else{
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'striped bordered',
	'attributes'=>array(
		'real_name',
		array(
			'label'=>'学号',
			'value'=>$usc->school_unique_id,
		),
		array(
			'label'=>'班级',
			'value'=>$ucls->name,
		),
		array(
			'label'=>'年级',
			'value'=>$ucls->grade_info->grade_name,
		),
		'user_info.email',
		'user_info.mobile',
		array(
			'label'=>'用户头像',
			'type'=>'raw',

			'value'=>$avatarCode,
		),
		'description',
	),
)); ?>
