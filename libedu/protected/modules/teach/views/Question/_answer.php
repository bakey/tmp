<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>



<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
	<h4>知识点关联</h4>
	<?php echo CHtml::checkBoxList('kprelation',$skp,$kp);?>
	<div class="row">
		<?php echo CHtml::label('请选择回答类型','Answer[type]',array('required'=>true));?>
		<?php echo CHtml::dropDownList('Answer[type]',2,array('0'=>'评论','1'=>'追问','2'=>'回答'));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>
		<?php
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'details',
		'editorOptions' => array(
			'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
			)
	));
	?>
		<?php echo $form->error($model,'details'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
