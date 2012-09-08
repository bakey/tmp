<?php
/* @var $this LibClassApplyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Class Applies',
);

$this->menu=array(
	array('label'=>'Create LibClassApply', 'url'=>array('create')),
	array('label'=>'Manage LibClassApply', 'url'=>array('admin')),
);
?>

<h1>Lib Class Applies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
