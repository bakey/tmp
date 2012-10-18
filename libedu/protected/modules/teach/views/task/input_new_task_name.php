<script type="text/javascript">
function close_model()
{
	$('#overlays .modal').fadeOut(80);
	$('#overlays').removeClass();
	$(document).unbind('keyup');
}
function submit_and_redirect()
{
	$.ajax(
			{
				url : '<?php echo Yii::app()->params['index_path']; ?>?r=teach/task/newtaskname',
				data: $("#create_task_name_form").serialize(),
				type: 'POST',
				success: function(resp) {
					var ret = eval( '(' + resp + ')' );
					window.location.href = '<?php echo Yii::app()->params['index_path']; ?>?r=teach/task/create&task_id=' + ret.task_id ;					
				}			
			}
		);
}
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'create_task_name_form',
		'enableAjaxValidation'=>true,
		'htmlOptions'=>array('id'=>'create_task_name_form'),
)); ?>
<?php echo $form->errorSummary($task_model); ?>
	<p>
		<?php echo $form->labelEx($task_model,'name'); ?>
		<?php echo $form->textField($task_model , 'name' , array('size' => 60 , 'maxlength' => 255 )); ?>
		<?php echo $form->error($task_model,'name'); ?>
	</p>
		<p>
		<?php echo $form->labelEx($task_model,'description'); ?>
		<?php echo $form->textField($task_model , 'description' , array('size' => 60 , 'maxlength' => 1024 )); ?>
		<?php echo $form->error($task_model,'description'); ?>
	</p>
	<p>
		<button class="sugar col_3" onclick="submit_and_redirect()"><span>下一步</span></button>
		<button class="sugar col_3" onclick="close_model()"><span>取消</span></button>
	</p>
<?php $this->endWidget(); ?>
