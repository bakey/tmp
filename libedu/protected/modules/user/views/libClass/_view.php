<?php
/* @var $this LibClassController */
/* @var $data LibClass */
?>

<div class="view">

	<b><?php echo "班级ID" ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data['id']), array('viewstudent', 'class_id'=>$data['id'])); ?>
	<br />


	<b><?php echo "班级名称"; ?>:</b>
	<?php echo CHtml::encode($data['name']); ?>
	<br />



</div>