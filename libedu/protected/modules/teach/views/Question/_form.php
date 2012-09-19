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

	<div class="row">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
		
	<?php 
		$url = 'edition/ajaxFillTree&edition_id=2';
		$this->widget(
			    'CTreeView',
				array(
		            'animated'=>'fast', //quick animation
		            'collapsed' => false,
		            'url' => array( $url ), 
				)
		);
	?>
	<?php echo $form->error($model,'item'); ?>
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