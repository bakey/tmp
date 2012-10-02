<?php
$this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider' => $dataProvider,
		'type' => 'bordered striped',
		'columns'=>array(
				array(
						'name'=>'第几节',
						'value'=>'$data["edi_index"]',
						'type'=>'raw',
				),
				array(
						'name'=>'内容',
						'value'=>'$data["content"]',
						//'value' => 'CHtml::link($data["content"] , $data["url"])',
						'type'=>'raw',
				),
				array(
						'name'=>'操作',
						'value'=>'CHtml::link($data["operate"] , $data["url"])',
						'type' => 'raw',
				),
		),
));
?>