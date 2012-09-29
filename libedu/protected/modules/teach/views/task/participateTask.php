<div class="well">
	<?php
	$ajax_callback_js = 'function(data , status , jq_obj ){
				var task_res = eval(data);
				$.each( task_res ,function(name,value) {
					var element_obj = eval( value );
					$.each( element_obj, function(n,v){
						var text = "";
						show_right_id = "problem_id_" + n + "_right";
						show_wrong_id = "problem_id_" + n + "_wrong";
						if ( v > 0 ) {							
							$("#" + show_right_id ).show();
							$("#" + show_wrong_id ).hide();							
						}else {
							$("#" + show_right_id ).hide();
							$("#" + show_wrong_id ).show();	
						}							 
					} )
       			});
			}';
		$alert_js = 'function( xhr ){
       			if ( confirm("确定提交?") ) return true;
       			else return false;
			}';
		echo CHtml::beginForm( 
				CController::createUrl('/teach/task/ajaxcheckanswer') . "&task_id=" . $task_id  ,
				'post',
				array()
			);
    		$this->widget('bootstrap.widgets.TbListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_answer_problem',
    	));
    	echo CHtml::ajaxSubmitButton(
    				'提交' , 
    				 CController::createUrl('/teach/task/ajaxcheckanswer') . "&task_id=" . $task_id ,
    				 array(
    				 	'beforeSend' => $alert_js,
    				 	'success' => $ajax_callback_js , 
    				 )
    			);
    	echo CHtml::resetButton('清除答案');
    	echo CHtml::endForm();
    	?>
</div>