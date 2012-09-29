<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<div class="form" id="form-container">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'libuser-form',
	'enableAjaxValidation'=>true,
	'inlineErrors'=>true,
	'htmlOptions'=>array('class'=>'well'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
	<legend>
		账户资料	
	</legend>	

		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model,'mobile',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>	
			</div>
		</div>	
		<div class="control-group">
			<div class="controls">
				<?php echo $form->passwordFieldRow($model,'password',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<?php echo $form->passwordFieldRow($model,'repeatpassword',array('size'=>60,'maxlength'=>255,'class'=>'span5'))?>
			</div>
		</div>
	
	</fieldset>

	<fieldset>
		<legend>
			用户详细资料
		</legend>
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model,'realname',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model,'schooluniqueid',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">	
				<?php echo $form->labelEx($model,'classid'); ?>
				<?php echo $form->dropDownList($model,'classid', $classlist,array());?>
				<?php echo $form->error($model,'classid'); ?>
			</div>
		</div>
	
	</fieldset>
	<div class="controls">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'注册')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
$(document).ready(function(){
	$('#LibUser_password').val("");
	$('#LibUser_repeatpassword').val("");
});
</script>