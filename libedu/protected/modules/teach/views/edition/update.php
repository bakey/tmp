<?php
$this->breadcrumbs=array(
	'Update Edition',
);
?>
<h1>Update Editions</h1>
<h2>
<?php 
	echo("教材名称 :" . $edition->name . "<br>");
	echo("教材描述 :" . $edition->description . "<br>");
	?>
	</h2>
	<h3>
	目前的章节:
	</h3>
<?php $this->widget('zii.widgets.grid.CGridView',
		array('dataProvider'=>$dataProvider)
	);
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row">
		<?php echo $form->labelEx($new_item,'edi_index'); ?>
		<?php echo $form->textField($new_item,'edi_index',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($new_item,'edi_index'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($new_item,'content'); ?>
		<?php echo $form->textField($new_item,'content',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($new_item,'contents'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('增加一章'); ?>
	</div>
<?php $this->endWidget(); ?>
<?php 
$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => true,
            'url' => array('localhost/dev/libedu/index.php?r=teach/edition/ajaxFillTree'), 
		)
);
?>














