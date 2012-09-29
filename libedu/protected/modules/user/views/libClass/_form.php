<?php
/* @var $this LibClassController */
/* @var $model LibClass */
/* @var $form CActiveForm */
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<div class="form row well">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lib-class-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); 
	?>


		<?php echo $form->textFieldRow($model,'name',array('size'=>60,'maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'grade'); ?>

		<?php echo $form->labelEx($model,'classhead_id'); ?>
		<?php echo CHtml::dropDownList('LibClass[classhead_id]',null,$tinfo); ?>
		<?php echo $form->error($model,'classhead_id'); ?>

		<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'span6')); ?>
		
		<div class="controls">
		  <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'创建班级')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->