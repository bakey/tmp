<script type="text/javascript">
function connect_with_item( task_id )
{
	if( $('#problem_selected').children().length <= 0 ) {
		alert("你还没有选择题目");
		return false ;
	}
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/task/connectitem&task_id=' + task_id ,
    	///theme:      "dark",
    	width:      480,
    	height:     360,
    	/*layout:     "elastic",
    	url:        undefined,
    	content:    "<strong>HTML</strong> content",
    	padding:    "100px",*/
    	animation:  "fadeIn"
	});
}
function submit_task_form( task_id )
{
	$.ajax( 
	{
		url : 'index.php?r=teach/task/create&task_id=' + task_id ,
		data : $("#task-form").serialize(),
		type : 'post',
		success: function( resp ) {
			var submit_ret = eval( '(' + resp + ')' );
			window.location.href = submit_ret.redir_url;
		}
	}
);
	
	
}
</script>
<span style="margin-left:50px;font-size:30px">题库选题</span>
<span style="margin-left:30px">收藏的题</span>
<span style="margin-left:30px">自己出题</span>
<span style="margin-left:30px">测试过的试卷</span>
<span>
<div class="horizon_dotted_line"></div>
<div class="vertical_line"></div>
</span>
<span class="carton col_4 prblem_selected_info">

		<div style="margin-top:30px; margin-left:10px">
			<span class>
			               测试名: &nbsp; <?php echo $task_model->name ; ?>
				<br>您已勾选<span id="choice_problem_cnt">0</span>道选择题
			</span>
			<span style="position:absolute;top:22px; left:250px">
				<button onclick="connect_with_item(<?php echo $task_model->id; ?>);" style="float:right;">下一步</button>
			</span>
		</div>
		
</span>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'task-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	<?php echo $form->errorSummary($task_model); ?>		
	<div id="problem_selected" style="display:none"></div>	
	<?php
		$this->renderPartial( 'select_problem' , array(
			'problem_data' => $problem_data,
		) );
	?>
	
	<div id="item_selected" style="display:none"></div>
	

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