<?php
/* @var $this ProfileController */
/* @var $model Profile */

?>

<h1><?php echo $model->real_name; ?></h1>
<p></p>
<?php
$avatarCode = ''; 
if($model->avatar != 'default_avatar.jpg'){
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}else{
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}

$coursestring = '';
foreach($usc as $singlecls){
	$coursestring.=' '.$singlecls->name;
}

$clsstring = '';
foreach($ucls as $singlecls){
	$clsstring.=' '.$singlecls->name;
}

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'striped bordered',
	'attributes'=>array(
		'real_name',
		array(
			'label'=>'课程',
			'value'=>$coursestring,
		),
		array(
			'label'=>'授课班级',
			'value'=>$clsstring,
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
