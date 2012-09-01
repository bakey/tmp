<?php
$this->breadcrumbs=array(
	'Manage edition',
);
?>
<h1>Manage Editions</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			//'value'=>'CHtml::link(CHtml::encode($data->name), $data->url)'
		),
		array(
			'name'=>'description',
			'type'=>'raw',
			//'value'=>'CHtml::link(CHtml::encode($data->description), $data->url)'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
