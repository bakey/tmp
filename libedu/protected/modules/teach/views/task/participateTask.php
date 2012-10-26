<script type="text/javascript">
function submite_callback(data)
{
	var task_res = eval(data);
	$.each( task_res ,function(name,value) 
	{
		var element_obj = eval( value );
			$.each( element_obj, function(n,v)
			{
				var text = "";
				show_right_id = "problem_id_" + n + "_right";
				show_wrong_id = "problem_id_" + n + "_wrong";
				if ( v.res > 0 )
				{							
					$("#" + show_right_id ).fadeIn();
					$("#" + show_wrong_id ).hide();							
				}
				else 
				{
					$("#" + show_right_id ).hide();
					$('#correctans'+n).text(' '+v.sans+' 。');
					$("#" + show_wrong_id ).fadeIn();
					$('#pexplain'+n).fadeIn();
				}							 
			} )
		});
}

function show_ans_explain(pid)
{
	$.fn.modal({
		url : '<?php echo Yii::app()->createUrl("teach/problem/showansexplain");?>&problem_id=' + pid,
    	animation:  "fadeIn"
	});
}


function submit_answer()
{
	$('#submitansbtn').fadeOut();
	$.ajax(
			{
				url: '<?php echo CController::createUrl('/teach/task/ajaxcheckanswer') . "&task_id=" . $task_model->id ;?>',
				data: $('#run-task-form').serialize(),
				type: 'POST',
				success: submite_callback,
			}
	);
}
</script>
		<div style="padding-top:20px; margin-left:140px">
			<div>测试名: <?php echo $task_model->name; ?></div>
			备注: <?php echo $task_model->description; ?>
		</div>
		<div style="margin-left:680px">
		<button onclick="submit_answer();" id="submitansbtn">交卷</button>
		</div>
		<?php 
			/*echo CHtml::button(
    				 CController::createUrl('/teach/task/ajaxcheckanswer') . "&task_id=" . $task_model->id ,
    				 array(
    				 	'beforeSend' => $alert_js,
    				 	'success' => $ajax_callback_js , 
    				 ),
    				array('id'=>'taskSubmitBtn')
    			);*/
	?>
		<?php 
		echo CHtml::beginForm( 
				CController::createUrl('/teach/task/ajaxcheckanswer') . "&task_id=" . $task_model->id   ,
				'post',
				array( 'id' => 'run-task-form')
			);
    		/*$this->widget('zii.widgets.CListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_answer_problem',
    	));*/
		foreach( $problem_data->getData() as $problem )
		{
			echo '<div class="carton col_4 problem_des">';
			$this->renderPartial( '_view_running_task' , array('data' => $problem ) );
			echo '</div>';
		}
    	echo CHtml::endForm();
    	?>