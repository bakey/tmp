<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form" id="form-container">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libuser-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
	<legend>
		账户资料	
	</legend>	

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'repeatpassword'); ?>
		<?php echo $form->passwordField($model,'repeatpassword',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'repeatpassword'); ?>
	</div>
	</fieldset>

	<fieldset>
		<legend>
			用户详细资料
		</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'realname'); ?>
		<?php echo $form->textField($model,'realname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'realname'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'schooluniqueid'); ?>
		<?php echo $form->textField($model,'schooluniqueid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'schooluniqueid'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'classid'); ?>
		<?php echo $form->dropDownList($model,'classid', $classlist,array());?>
		<?php echo $form->error($model,'classid'); ?>
	</div>
	
	</fieldset>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '注册' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
$(document).ready(function(){
	$('#LibUser_password').val("");
	$('#LibUser_repeatpassword').val("");
});
</script>