<?php
/* @var $this LibClassController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Classes',
);

$this->menu=array(
	array('label'=>'Create LibClass', 'url'=>array('create')),
	array('label'=>'Manage LibClass', 'url'=>array('admin')),
);
?>

<h1>Lib Classes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
