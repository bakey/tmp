<?php
/* @var $this LibClassController */
/* @var $data LibClass */
?>

<div class="view">

	<b><?php echo "班级ID" ?>:</b>
	<?php 
		//echo CHtml::link(CHtml::encode($data['id']), array('viewstudent', 'class_id'=>$data['id']));
		echo CHtml::encode($data['id']);
	?>
	<br />


	<b><?php echo "班级名称"; ?>:</b>
	<?php 
		//echo CHtml::encode($data['name']);
		echo CHtml::ajaxLink($data['name'] ,
					CController::createUrl('libclass/getclassstudent'), 
					array(
						'type' => 'post',
						'data' => array('class'=>'1',),
						'update'=>'#student-view-id',
					)); 
	?>
	<br />
<div id='student-view-id'>
</div>


</div>