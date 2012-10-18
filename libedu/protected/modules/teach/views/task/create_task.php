
<h2>题库选题</h2>

<?php
	 echo $this->renderPartial('_form_add_task', array(
			'task_model'   =>$task_model,
			'problem_data' => $problem_data,			
		)); 
?>