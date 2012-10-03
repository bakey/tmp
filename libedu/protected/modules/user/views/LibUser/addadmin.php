<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="page-header">
  <h2>系统管理 <small>添加行政人员 - <?php echo $csc->name; ?></small></h2>
</div>
<?php if(isset($msg))echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button><h5>'.$msg.'</h5></div>'; ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form" id="form-container">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'libuser-form',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
	<legend>
		行政人员账号设置	
	</legend>	

	<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>
			</div>
		</div>

	<div class="control-group">
			<div class="controls">
		<?php echo CHtml::label('真实姓名','LibUser[realname]',array('required'=>true)); ?>
		<?php echo CHtml::textField('LibUser[realname]','',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>
	</div>
		</div>
	<div class="control-group">
			<div class="controls">
		<?php echo $form->passwordFieldRow($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		
	</div>
		</div>
	<div class="control-group">
			<div class="controls">
		<?php echo $form->passwordFieldRow($model,'repeatpassword',array('size'=>60,'maxlength'=>255)); ?>
	</div>
		</div>
	</fieldset>
	
	<div class="controls">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'添加行政人员')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
$(document).ready(function(){
	$('#LibUser_password').val("");
	$('#LibUser_repeatpassword').val("");
});
</script>