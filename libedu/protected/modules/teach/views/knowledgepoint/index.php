<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
知识点管理
</p>
<p>
<?php
/*$form = $this->beginWidget('CActiveForm' , array(
			'id'=>'course-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
					'validateOnSubmit'=>true,
					)
		));*/
?>
<?php
/*echo $form->dropDownList( 'country_id' , '' , array(
        'A' => '1',
        'B' => '2',)
		);*/
echo "科目: ";
echo CHtml::dropDownList( 'list_course','', $list_course ,
	array(
		'empty'=>'请选择一门课程',
		'onchange' => 'js:alert( $("#list_course").val() )',
		'ajax' => array(
			'type'=>'POST',
			'url'=>CController::createUrl('knowledgepoint/FilterKnowledgePoint'), //url to call.
			'update'=>'#city_id', //selector to update
			)
	 )
); 
echo " 年级:";
echo CHtml::dropDownList( 'list_grade' , '' , $list_grade ,
		array(
		'empty'=>'全部',
) );
//empty since it will be filled by the other dropdown
//echo CHtml::dropDownList('city_id','', array());

?> 
<?php
 $this->widget('zii.widgets.grid.CGridView',
		array(
			'dataProvider'=>$dataProvider,
		)
	);
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edition-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row">
		<?php echo $form->labelEx($kp_model,'name'); ?>
		<?php echo $form->textField($kp_model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($kp_model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($kp_model,'description'); ?>
		<?php echo CHtml::activeTextArea($kp_model,'description',array('rows'=>10, 'cols'=>70)); ?>
		<?php /*echo $form->textField($kp_model,'description',array('size'=>60,'maxlength'=>512));*/ ?>
		<?php echo $form->error($kp_model,'description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($kp_model,'level'); ?>
		<?php echo $form->textField($kp_model,'level',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($kp_model,'level'); ?>
	</div>
	
		<div class="row">
		<?php echo $form->labelEx($kp_model,'course_id'); ?>
		<?php echo $form->textField($kp_model,'course_id',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($kp_model,'course_id'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
<?php $this->endWidget(); ?>
