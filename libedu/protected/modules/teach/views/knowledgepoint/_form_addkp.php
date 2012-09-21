<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'edition-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
				'validateOnSubmit'=>true,
		),
)); ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row">
		<?php echo $form->labelEx($kp_model,'name'); ?>
		<?php echo $form->textField($kp_model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($kp_model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($kp_model,'description'); ?>
		<?php echo CHtml::activeTextArea($kp_model,'description',array('rows'=>10, 'cols'=>70)); ?>
		<?php /*echo $form->textField($kp_model,'description',array('size'=>60,'maxlength'=>512));*/ ?>
		<?php echo $form->error($kp_model,'description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($kp_model,'level'); ?>
		<?php echo $form->textField($kp_model,'level',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($kp_model,'level'); ?>
	</div>
	
		<div class="row">
		<?php echo $form->labelEx($kp_model,'subject'); ?>
		<?php echo $form->textField($kp_model,'subject',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($kp_model,'subject'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
<?php $this->endWidget(); ?>