<?php
$this->breadcrumbs=array(
	'Tasks',
);

$this->menu=array(
	array('label'=>'创建测验', 'url'=>array('create')),
	array('label'=>'管理测验', 'url'=>array('admin')),
);
?>

<h1>Tasks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
