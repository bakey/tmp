<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a.fancylink',
        'config'=>array('minWidth'=>'300px','minHeight'=>'100px','closeBtn'=>false),));  
?>  
<a href="#fancydata" class="fancylink" id="loadinghover" style="display:none">&nbsp;</a>
<div style="display:none">
	<div id="fancydata">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
		<p>请稍等，正在和服务器通信……</p>
	</div>
</div>

<div class="form" id="form-container">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libuser-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>
			用户类型		
		</legend>	
	<?php 
		echo CHtml::dropDownList('usrtype','0',array('0'=>'学生','1'=>'教师'),array('ajax'=>array(
				'url'=>Yii::app()->createUrl('/user/libuser/register'),
				'update'=> '#form-container',
				'data'=> array('role'=>'js:$(this).val()'),
				'beforeSend'=>'js:function(){$(\'#loadinghover\').trigger(\'click\');}',
				'complete'=>'js:function(){$(\'.fancybox-wrap\').stop(true).trigger(\'onReset\').fadeOut(500);
																$(\'.fancybox-overlay\').fadeOut();$(\'body\').removeClass(\'fancybox-lock\');}',
			)));
	?>
	</fieldset>
	
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
	</fieldset>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '注册' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
