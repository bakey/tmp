<?php
$this->breadcrumbs=array(
	'测试首页'=>array('index'),
	'新建测试',
);

$this->menu=array(
	array('label'=>'测试首页', 'url'=>array('index')),
	array('label'=>'管理测试', 'url'=>array('admin')),
);
?>

<h1>创建测试</h1>

<?php
	 echo $this->renderPartial('_form_add_task', array(
			'task_model'   =>$task_model,
			'problem_data' => $problem_data,			
		)); 
?>