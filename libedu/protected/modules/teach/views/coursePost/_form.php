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

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textArea($model,'post',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row buttons">
		<?php
		 echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		 echo CHtml::submitButton('存草稿' ,array('name'=>'draft'));
		 echo CHtml::submitButton('取消' ,array('name'=>'cancel'));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->