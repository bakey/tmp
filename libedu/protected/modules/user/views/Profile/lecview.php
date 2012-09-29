<?php
/* @var $this ProfileController */
/* @var $model Profile */

?>

<h1><?php echo $model->real_name; ?>的账号</h1>
<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons'=>array(
        array('label'=>'编辑', 'url'=>Yii::app()->createUrl('/user/profile/update',array('id'=>$model->uid))),
        array('label'=>'修改密码', 'url'=>Yii::app()->createUrl('/user/libuser/changepassword',array('id'=>$model->uid))),
    ),
)); ?>
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
