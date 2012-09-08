<?php
/* @var $this LibClassApplyController */
/* @var $model LibClassApply */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'applicant'); ?>
		<?php echo $form->textField($model,'applicant'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approver'); ?>
		<?php echo $form->textField($model,'approver'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_id'); ?>
		<?php echo $form->textField($model,'class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'statement'); ?>
		<?php echo $form->textArea($model,'statement',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->