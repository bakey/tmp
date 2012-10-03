<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-post-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
	 echo $form->labelEx($model,'post');
	 echo $form->error($model,'post');
?>

<?php
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'fileUpload'  => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'autosave'=> $base_auto_save_url ,
				'interval' => 5,
				'autosaveCallback'=>"js:function(data,redactor_ins,doc){
					var json_obj = eval( data );
					redactor_ins.opts.autosave = '" . $base_auto_save_url . "'+ '&post_id=' + json_obj.post_id ;".
					"var createUrl = '" . $base_create_url . "' + json_obj.post_id;" .  
					"doc.getElementById('course-post-form').setAttribute('action' , createUrl );				 
				}",
				'focus' => false,
		  ),
	));
?>

<div class="row buttons">
		<?php
		 echo CHtml::submitButton('发布' ,  array('name'=>'publish'));
		 echo CHtml::submitButton('存草稿', array('name'=>'draft'));
		 echo CHtml::submitButton('预览' ,  array('name'=>'draft'));
		 echo CHtml::submitButton('取消' ,  array('name'=>'cancel'));
		?>
</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->