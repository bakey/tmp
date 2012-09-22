<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */
/* @var $form CActiveForm */
?>

$('#CoursePost_post').redactor({"imageUpload":"http:\/\/localhost\/dev\/libedu\/index.php?r=teach\/coursepost\/upload","autosave":"http:\/\/localhost\/dev\/libedu\/index.php?r=teach\/coursepost\/autosave&item_id=113","interval":5,"autosaveCallback":"js::function(d,o){alert(\"d\");}","focus":false,"lang":"en","toolbar":"default"});
</script>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-post-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->labelEx($model,'post'); ?>
<?php
	/*$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'autosave'=> Yii::app()->createAbsoluteUrl('teach/coursepost/autosave&item_id=' . $item_id),
				'interval' => 5,
				'autosaveCallback' => 'js::function(d,o){alert("d");}',
				'focus' => false,
		  ),
	));*/
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