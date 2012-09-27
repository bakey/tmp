<?php
$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'测试首页', 'url'=>array('index')),
	array('label'=>'管理测试', 'url'=>array('admin')),
);
?>

<h1>创建测试</h1>

<?php
	 echo $this->renderPartial('_form', array('model'=>$model)); 
?>