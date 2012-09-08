<?php
/* @var $this LibClassApplyController */
/* @var $data LibClassApply */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('applicant')); ?>:</b>
	<?php echo CHtml::link($data->applicant_info->user_profile->real_name, array('view', 'id'=>$data->applicant)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approver')); ?>:</b>
	<?php echo CHtml::encode($data->approver_info->user_profile->real_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_id')); ?>:</b>
	<?php echo $data->class_info->school_info->name.' - '.$data->class_info->name; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statement')); ?>:</b>
	<?php echo CHtml::encode($data->statement); ?>
	<br />

	<b>操作:</b><br />
	<?php echo CHtml::link('批准', array('approve', 'id'=>$data->applicant)); ?>
	<?php echo CHtml::link('拒绝', array('delete','id'=>$data->applicant)); ?>
	<br />


</div>