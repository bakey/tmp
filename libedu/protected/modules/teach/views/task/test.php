	<div class="well">
	<?php
		echo CHtml::beginForm( 
				CController::createUrl('/teach/task/test'),
				'post',
				array()
			);
    		$this->widget('bootstrap.widgets.TbListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_answer_problem',
    		));
    	echo CHtml::submitButton('提交' , array() );
    	echo CHtml::resetButton('清除答案');
    	echo CHtml::endForm();
    	?>
    	</div>