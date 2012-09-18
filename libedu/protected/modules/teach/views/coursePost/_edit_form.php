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
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
			'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
		  )
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