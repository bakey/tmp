<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-editions-id',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
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