

<h1>创建测试</h1>

<?php
	 echo $this->renderPartial('_form_add_task', array(
			'task_model'   =>$task_model,
			'problem_data' => $problem_data,			
		)); 
?>