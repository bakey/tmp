<?php
$this->breadcrumbs=array(
	'Problems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Problem', 'url'=>array('index')),
	array('label'=>'Manage Problem', 'url'=>array('admin')),
);
?>

<h1>Create Problem</h1>

<?php echo $this->renderPartial('_form_add_problem', array('model'=>$model)); ?>