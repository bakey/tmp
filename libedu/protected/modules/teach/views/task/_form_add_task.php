<script type="text/javascript">
function select_item()
{
	//alert('xxx');
}
</script>
<h2>题库选题</h2>
<div class="horizon_dotted_line"></div>
<div class="carton col_4 prblem_selected_info">
		测试名: &nbsp; <?php echo $task_model->name ; ?>
		<div>您已勾选5道选择题，6道判断题</div>
		<button onclick="select_item(); return false;" style="float:right;">下一步</button>
</div>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'task-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<?php echo $form->errorSummary($task_model); ?>		
			
	<?php
		$this->renderPartial( 'select_problem' , array(
			'problem_data' => $problem_data,
		) );
	?>
	<div id="statusID"></div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
	<script type="text/javascript">
		function select_item( cid ){	
			$('#selected_item').val(cid);	
			$('#hint_text').fadeIn(300);
			$('#item_tree').fadeOut(300);
			$('#relation_item').text( $('#'+cid).text() );
		}
		function select_kp( kpid ) {
			$('#hint_select_kp').fadeIn(300);
			$('#hint_select_kp').append('<span syle=\'color:blue\'>' + $('#kp_'+kpid).text() +'</span>,');
			$('#wrap_kp').append('<input name="Task[kp][]" type="text" value="'+kpid+'" />');		
		}
		
	</script>