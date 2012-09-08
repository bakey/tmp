<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div id="choose-box-wrapper">
	  <div id="choose-box">
		<div id="choose-box-title">
			<span>选择学校</span>
		</div>
		<div id="choose-a-province">
		</div>
		<div id="choose-a-school">
		</div>
		<div id="choose-box-bottom">
			<input type="botton" onclick="hide()" value="关闭" />
		</div>
	  </div>
	</div>


<div class="form" id="form-container">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libuser-form',
	'enableAjaxValidation'=>true,
)); 

	$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/jquery.rrschool.js');
		$cs->registerScriptFile($baseUrl.'/js/jquery.rrschool.list.js');
		$cs->registerCssFile($baseUrl.'/css/rrschool.css');
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
	<legend>
		基本资料	
	</legend>	
	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
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
			详细资料
		</legend>
	<div class="row">
		<?php echo CHtml::label('请选择您的学校','schoolid');?>
		<?php echo CHTML::textField('schoolid',null,array('onClick'=>"pop()",'readonly'=>'readonly'));?>
	</div>
	</fieldset>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '注册' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
