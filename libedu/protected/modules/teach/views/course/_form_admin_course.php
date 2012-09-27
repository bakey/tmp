
<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'name'=>'name',
						'type'=>'raw',
						//'value'=>'CHtml::link(CHtml::encode($data->name), array("update"))'
				),
				array(
						'name'=>'description',
						'type'=>'raw',
						//'value'=>'CHtml::link(CHtml::encode($data->description), $data->url)'
				),
				array(
						'name'=>'school_id',
						'type'=>'raw',
				),
				array(
						'class'=>'CButtonColumn',
						'template'=>'{view}{update}{delete}',
						/*'buttons'=>array
						(
								'down' => array
								(
										'label'=>'[+]',
										//'url'=>'"#"',
										//'click'=>'function(){alert("Going down!");}',
								),
						),*/
				),
		),
)); ?>