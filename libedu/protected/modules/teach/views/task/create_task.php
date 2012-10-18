<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<?php
	 echo $this->renderPartial('_form_add_task', array(
			'task_model'   =>$task_model,
			'problem_data' => $problem_data,	
	 		'course_model' => $course_model,		
		)); 
?>