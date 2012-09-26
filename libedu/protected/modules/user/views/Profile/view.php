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
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'striped bordered',
	'attributes'=>array(
		'uid',
		array(
			'label'=>'用户头像',
			'type'=>'raw',

			'value'=>$avatarCode,
		),
		'real_name',
		'user_info.user_name',
		'user_info.email',
		'user_info.mobile',
		'description',
	),
)); ?>
