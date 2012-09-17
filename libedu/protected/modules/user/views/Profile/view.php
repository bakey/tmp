<?php
/* @var $this ProfileController */
/* @var $model Profile */

?>

<h1><?php echo $model->real_name; ?>的账号</h1>
<h3><a href="<?php echo Yii::app()->createUrl('/user/profile/update',array('id'=>$model->uid)); ?>">编辑</a>&nbsp; | &nbsp; <a href="<?php echo Yii::app()->createUrl('/user/libuser/changepassword',array('id'=>$model->uid)); ?>">修改密码</a></h3>

<?php
$avatarCode = ''; 
if($model->avatar != 'default_avatar.jpg'){
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}else{
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
}
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
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
