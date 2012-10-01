<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
		'dataProvider'=>$dataProvider,
		'id' => 'publish-student-form',
		'columns'=>array(
				array(
 						'name'=>'id',
 						'type'=>'raw',
 				),
 				array(
 						'name'=>'email',
 						'type'=>'raw',
 				),
				array(
						'class'=>'CCheckBoxColumn',
						'value'=> '$data[\'id\']',
						'checked'=>'1',
						//'template'=>'{delete}',
						/*'buttons'=>array
						(
								'delete' => array
								(
										'url'=>'"#"',
										'click'=>'',
								),
						),*/
				),
		),
)); ?>