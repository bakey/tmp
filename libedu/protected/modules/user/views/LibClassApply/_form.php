<?php
/* @var $this LibClassApplyController */
/* @var $model LibClassApply */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lib-class-apply-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'class_id'); ?>
		<?php echo CHtml::dropDownList('LibClassApply[class_id]', '-1', $classlist);?>
		<?php echo $form->error($model,'class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'statement'); ?>
		<?php echo $form->textArea($model,'statement',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'statement'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交申请' : '保存'); ?>
	</div>

<?php $this->endWidget();  ?>

</div><!-- form -->