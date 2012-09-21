<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<h1><?php echo $msg; ?></h1>
<div class="form" id="form-container">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libuser-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
	<legend>
		用户激活	
	</legend>	

	<div class="row">
		<?php echo CHtml::label('您的真实姓名','LibUser[realname]',array('required'=>true)); ?>
		<?php echo CHtml::textField('LibUser[realname]','',array('size'=>60,'maxlength'=>255)); ?>
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
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '完成激活' : '完成激活'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
$(document).ready(function(){
	$('#LibUser_password').val("");
	$('#LibUser_repeatpassword').val("");
});
</script>