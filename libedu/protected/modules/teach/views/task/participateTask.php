<div class="well">
	<?php
	$ajax_callback_js = 'function(data , status , jq_obj ){
				var task_res = eval(data);
				$.each( task_res ,function(name,value) {
					var element_obj = eval( value );
					$.each( element_obj, function(n,v){
						var text = "";
						if ( v > 0 ) {
							text = $("#problem_id_" + n).html() + " <div style=\"color:red\">本题正确</div>";
						}else {
							text = $("#problem_id_" + n).html() + " <div style=\"color:red\">本题错误</div>";
						}
						$("#problem_id_" + n).html( text );							 
					} )
       			});
			}';
		echo CHtml::beginForm( 
				CController::createUrl('/teach/task/ajaxcheckanswer'),
				'post',
				array()
			);
    		$this->widget('bootstrap.widgets.TbListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_answer_problem',
    	));
    	echo CHtml::ajaxSubmitButton(
    				'提交' , 
    				 CController::createUrl('/teach/task/ajaxcheckanswer'),
    				 array(
    				 	'success' => $ajax_callback_js , 
    				 		)
    			);
    	echo CHtml::resetButton('清除答案');
    	echo CHtml::endForm();
    	?>
</div>