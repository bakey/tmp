<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户控制面板',
);

$this->menu=array(
	array('label'=>'注册', 'url'=>array('create')),
);
?>

<h1>Users</h1>

<?php $this->widget('zii.widgets.grid.CGridView',
		array('dataProvider'=>$dProvider)
	);
?>