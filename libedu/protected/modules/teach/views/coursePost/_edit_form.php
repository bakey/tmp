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
<?php echo $form->labelEx($model,'post'); ?>

<?php

	$baseAutoSaveUrl = Yii::app()->createAbsoluteUrl('teach/coursepost/autosave&item_id=' . $item_id);
	$baseCreateUrl = Yii::app()->createAbsoluteUrl('teach/coursepost/create&item_id=' . $item_id . '&post_id=');
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'debugMode' => true,
		'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'autosave'=> $baseAutoSaveUrl,
				'interval' => 5,
				'autosaveCallback'=>"js:function(data,redactor_ins,doc){
					var json_obj = eval( data );
					redactor_ins.opts.autosave = '" . $baseAutoSaveUrl . "'+ '&post_id=' + json_obj.post_id ;".
					"var createUrl = '" . $baseCreateUrl . "' + json_obj.post_id;" .  
					"doc.getElementById('course-post-form').setAttribute('action' , createUrl );				 
				}",
				'focus' => false,
		  ),
	));
?>

<div class="row buttons">
		<?php
		 echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		 echo CHtml::submitButton('存草稿' ,array('name'=>'draft'));
		 echo CHtml::submitButton('取消' ,array('name'=>'cancel'));
		?>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->